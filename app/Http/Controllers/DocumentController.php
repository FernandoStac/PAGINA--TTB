<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\document;
use App\companie;
use App\configManager;
use App\Notifications\NewNotification;
use Mail;
Use Session;
use Redirect;
use File;
use ZipArchive;


class DocumentController extends Controller{
  
  public function index($companieName){
    
    return view('companie.documents.load');
  }



  public $user_mail;
  public $empresa_mail;
  public function store(Request $request){

    $now = new \DateTime();
    $date_Actual =$now->format('Y-m-d');
 		$monthYear =$now->format('Y-m');
    $user_id=Auth::user()->id;
    $namecompanie=Auth::user()->companie->name_short;
    $idcompanie=Auth::user()->companie_id;
    $this->empresa_mail=Auth::user()->companie->email;
    $this->user_mail=Auth::user()->email;
    $route=$this->route_url();


    $file=$request ->file('document');

    //name now is uuid
    $exten=strtolower($file->getClientOriginalExtension());
    $serie=$request ->input('serie');
    $folio=$request ->input('folio');
    $nameAndExt=$serie.'_'.$folio.'.'.$exten;
    $path=public_path() . '/files/'.$namecompanie.'/'.$monthYear;
    $fileName=$file->getClientOriginalName();
    $moved=$file->move($path,$nameAndExt);

    if($moved){
         $fileFac=new document();
         $fileFac->name=$fileName;
         $fileFac->serie=$serie;
         $fileFac->folio=$folio;
         $fileFac->date=$date_Actual;
         $fileFac->document=$nameAndExt;
         $fileFac->user_id=$user_id;
         $fileFac->companie_id=$idcompanie;
         $fileFac->url='files/'.$namecompanie.'/'.$monthYear.'/';
         $fileName=$route.'files/'.$namecompanie.'/'.$monthYear.'/'.$nameAndExt;
         $fileFac->save();

          try {


            $user = \App\User::find($user_id);
            $user->notify(new NewNotification($fileName));

            $companie = \App\companie::find($idcompanie);
            $companie->notify(new NewNotification($fileName));

            
          } catch (\Swift_TransportException $e) {


            return response()->json(['types'=>"error",'ms'=>'Se cargo el documento pero hay problemas con las notificaciones.',]);

          }

    // $user = \App\User::find($companie_id);
    // $user->notify(new NewNotification($fileName));





            // Mail::send('system.documents.send',['filename' => $fileName, 'name'=> 'Archivo cargado...'],function($msj){
            //           $msj->subject('Se cargo un nuevo archivo');
            //           $msj->to($this->user_mail);
            //           $msj->cc($this->empresa_mail);
            //       });


            return response()->json(['types'=>"success",'ms'=>'Documento cargado!']);

          
         
    }

      return response()->json(['types'=>"error",'ms'=>'Lo sentimos el archivo no se puede subir :(']);
  }




  public function destroy($id){
    $notification="No fue posible eliminar el  documento, no existe o esta siendo utilizado :(";
    $documentf=document::find($id);
    $fullPath=public_path() .'/'.$documentf->url.$documentf->document;
    $deleted=File::delete($fullPath);   
    $documentf->delete();
    $notification="Documento eliminado :)";
    return back()->with(compact("notification"));
  }


  public function destroyed(Request $request){
    $id=$request ->input('id');

    $notification="No fue posible eliminar el  documento, no existe o esta siendo utilizado :(";
    $documentf=document::find($id);
    if(is_null($documentf)){

       return response()->json("El archivo ya no existia.");
    }  
    $fullPath=public_path() .'/'.$documentf->url.$documentf->document;
    $deleted=File::delete($fullPath); 
    
    $documentf->delete();
    $notification="Documento eliminado :)";
 
    return response()->json($notification);
      
  }

  public function zip(Request $request){

   $initial=\Carbon\Carbon::parse($request->fechainicial)->format('Y-m-d');
    $finald=\Carbon\Carbon::parse($request->fechafinal)->format('Y-m-d');

    if($request->has('download')) {
        $user_id=Auth::user()->id;
   
        
        $documents= document::where('date',">=",$initial)  
                            ->where('date',"<=",$finald)  
                            ->where('companie_id',$request->idem)  
                            ->get();
        

        // Define Dir Folder
        $public_dir=public_path();
        // Zip File Name
        $zipFileName = 'All.zip';
        $fullPath=public_path() . '/downloads/facturas/'.$zipFileName ;
        $deleted=File::delete($fullPath); 

        // Create ZipArchive Obj
        $zip = new ZipArchive;

        if ($zip->open($public_dir . '/downloads/facturas/' . $zipFileName, ZipArchive::CREATE) === TRUE) {    
            // Add Multiple file   

            $cont=0;
            foreach($documents as $document) {
                $zip->addFile($public_dir .'/'.$document->url.$document->document, $document->document);
                $cont++;
            }        

            $zip->close();

        }

        // Set Header
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath=$public_dir.'/downloads/facturas/'.$zipFileName;
        // Create Download Response
        if(file_exists($filetopath)){
            return response()->download($filetopath,$zipFileName,$headers);
        }
    }
    return back();
  }




  public function zip_filter(Request $request){
    $datoss=$request->input('fieldValues'); //Aqui obtienes el valor del input ajax
    $datos=explode(",", $datoss);

    $public_dir=public_path();
    // Zip File Name
    $zipFileName = 'All_Filters.zip';
    $fullPath=public_path() . '/downloads/facturas/'.$zipFileName ;
    $deleted=File::delete($fullPath); 

    $zip = new ZipArchive;

    if ($zip->open($public_dir . '/downloads/facturas/' . $zipFileName, ZipArchive::CREATE) === TRUE) {    
            // Add Multiple file   

      $cont=0;
      foreach($datos as $dato) {

            $document=document::find($dato);

          $zip->addFile($public_dir .'/'.$document->url.$document->document, $document->document);
          $cont++;
      }        

      $zip->close();

    }

    // Set Header
    $headers = array(
        'Content-Type' => 'application/octet-stream',
    );
    $filetopath=$public_dir.'/downloads/facturas/'.$zipFileName;
    // Create Download Response
    if(file_exists($filetopath)){
        return response()->download($filetopath,$zipFileName,$headers);
    }
  return back();
  }



  public function show($companieName){
    $route=$this->route_url();
    $companie=companie::where("name_short",$companieName)->first();
    $user_id=Auth::user()->id;
    $role=Auth::user()->role_id;

    if(is_null($companie) || empty($companie)){
        abort(404);
    }


    if($role>2){

    $documents=document::where("companie_id",$companie->id)
              ->orderBy('created_at','desc')
              ->paginate(10);
      return view('companie.documents.index')->with(compact('documents','role','companie','route'));
    }

      $documents=document::where("companie_id",$companie->id)
              ->orderBy('created_at','desc')
              ->paginate(500);

    return view('system.companies.documents')->with(compact('documents','role','companie','route'));
  }


  public function sendemail(){
    $user_namecompanie=Auth::user()->comapanie->name_short;
     Mail::send('system.documents.send',['filename' => "prueba", 'name'=> "prueba"],function($msj){
                  $msj->subject('Se cargo un nuevo archivo');
                  $msj->cc('javeliecm@gmail.com');
              });
     return back();
  }

  public function route_url(){    
    $route=configManager::find(1);
    return $route=$route->route;
  }


public function notify(){
    $ruta="holamundo";
    $user = \App\companie::find(1);
    $user->notify(new NewNotification($ruta));




}


  // public function try(){
  //   $dssd=document::find(1023);
  //   $dssd->delete();
  // }


  // public function emailToCompanieAndAdmin($fileName){
  //   try {

  //     dd(Mail::send('system.documents.send',['filename' => $fileName, 'name'=> 'Archivo cargado...'],function($msj){
  //               $msj->subject('Se cargo un nuevo archivo');
  //               $msj->to($this->user_mail);
  //               $msj->cc($this->empresa_mail);
  //           }));

  //     return true();
      
  //   } catch (\Exception $e) {
  //     return false();
  //   }
     
     
  // }

}
