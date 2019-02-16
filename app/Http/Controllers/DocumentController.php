<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\document;
use App\companie;
use App\configManager;
use App\Notifications\NewNotification;
use Mail;
Use Session;
use Redirect;
use File;
use ZipArchive;
use App\Access;


class DocumentController extends Controller{
  
  public function index(){
    
    return view('companie.documents.load');
  }



  public $user_mail;
  public $empresa_mail;
  public function store(Request $request){

    // return response()->json(['types'=>"success",'ms'=>'si funciona xD']);

    $now = new \DateTime();
    $date_Actual =$now->format('Y-m-d');
 		$monthYear =$now->format('Y-m');
    $user_id=Auth::user()->id;
    $user_email=Auth::user()->email;
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
    $nameAndExt=$user_email.'_'.$serie.'_'.$folio.'.'.$exten;
    $path=public_path() . '/files/'.$namecompanie.'/'.$user_email.'/'.$monthYear;
    $fileName=$file->getClientOriginalName();
    $moved=$file->move($path,$nameAndExt);

    $xml=$request ->file('xml');

    $sixml= false;

    if(!is_null ($xml))
{ $extenxml=strtolower($xml->getClientOriginalExtension());
  $nameAndExtxml=$user_email.'_'.$serie.'_'.$folio.'.'.$extenxml;
  $fileNamexml=$xml->getClientOriginalName();
  $movedxml=$xml->move($path,$nameAndExtxml);
  $sixml=true;
}
   



    if($moved){
         $fileFac=new document();
         $fileFac->name=$fileName;
         $fileFac->serie=$serie;
         $fileFac->folio=$folio;
         $fileFac->date=$date_Actual;
         $fileFac->document=$nameAndExt;
         $fileFac->user_id=$user_id;
         $fileFac->companie_id=$idcompanie;
         $fileFac->url='files/'.$namecompanie.'/'.$user_email.'/'.$monthYear.'/';
         $fileName=$route.'files/'.$namecompanie.'/'.$user_email.'/'.$monthYear.'/'.$nameAndExt;
         
      if($sixml){
        $fileFac->xml=true;
      }
      $fileFac->save();
          try {


            $user = \App\User::find($user_id);
            $user->notify(new NewNotification($fileName));

            //$companie = \App\companie::find($idcompanie);
            //$companie->notify(new NewNotification($fileName));

            
          } catch (\Swift_TransportException $e) {


            return response()->json(['types'=>"error",'ms'=>'Se cargo el documento pero hay problemas con las notificaciones.',]);

          }


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
    if(Access::canEnter("Eliminar documentos")){
        $id=$request ->input('id');
        $documentf=document::find($id);
        if(is_null($documentf)){

               return response()->json(['types'=>"supererror",'ms'=>"El documento ya no existia"]);
        }  
        $fullPath=public_path() .'/'.$documentf->url.$documentf->document;
        $deleted=File::delete($fullPath); 
        
        $documentf->delete();
     
        return response()->json(['types'=>"succes",'ms'=>"El documento fue eliminado :)"]);
    }
    return response()->json(['types'=>"supererror",'ms'=>"Lo sentimos pero no tiene permisos para eliminar documentos"]);


      
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
    $type=Auth::user()->role->type;
    $role=Auth::user()->role_id;

   

    if($type=="provee"){
      $documents=document::select(DB::raw("id ,iif(v_1=1 and v_2=1 and v_3=1,'Aceptado',iif((v_1=1 or v_1 is null) and (v_2=1 or v_2 is null) and (v_3 is null) ,'En proceso','Rechazado')) as estatus ,document, url, created_at, serie, folio,observ_1,observ_2,observ_3"))->where("user_id",$user_id)
        ->orderBy('created_at','desc')
        ->paginate(1000);
      return view('companie.documents.index')->with(compact('documents','role','companie','route'));
    }else{
       if(is_null($companie) || empty($companie)){
              abort(404);
          }

     

      if(Access::canEnter("Evaluador 1")){
        $documents=document::where("companie_id",$companie->id)//->whereNull("id_v1")->whereNull("id_v2")->whereNull("id_v3")
                  ->orderBy('created_at','desc')
                  ->paginate(1000);
        $evaluacion_tipo=1;
        $evaluacion="Proceso 1";
      }elseif(Access::canEnter("Evaluador 2")){
         $documents=document::where("companie_id",$companie->id)//->whereNotNull("id_v1")->whereNull("id_v2")->whereNull("id_v3")->where("v_1",1)

        ->whereRaw('(v_1=1) or (v_2=1) or (v_3=1 or v_3=0) or (v_1=1 and v_2=1 and v_3=1)')
                  ->orderBy('created_at','desc')
                  ->paginate(1000);
        $evaluacion_tipo=2;
        $evaluacion="Proceso 2";
      }elseif(Access::canEnter("Evaluador 3")){
         $documents=document::where("companie_id",$companie->id)->whereNotNull("id_v1")->whereNotNull("id_v2")->whereNull("id_v3")->where("v_1",1)->where("v_2",1)
                  ->orderBy('created_at','desc')
                  ->paginate(1000);
        $evaluacion_tipo=3;
        $evaluacion="Proceso 3";
      }elseif(Access::canEnter("Evaluador Maestro")){

         $documents=document::where("companie_id",$companie->id)
                  ->orderBy('created_at','desc')
                  ->paginate(1000);
          $evaluacion_tipo=777;
          $evaluacion="Evaluación completa";
      }else{
        $documents=document::where("companie_id",$companie->id)
                  ->orderBy('created_at','desc')
                  ->paginate(1000);
          $evaluacion_tipo=null;
          $evaluacion="";
      }

        return view('system.companies.documents')->with(compact('documents','role','companie','route','evaluacion_tipo','evaluacion'));

    }

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


  public function document_validate(Request $request){
      $document=document::find($request->id);
      $user_id=Auth::user()->id;
    if($request->tipo_evaluador==1){
      $document->id_v1=$user_id;
      $document->v_1=$request->validation_document;
      $document->observ_1=$request->validation_document_ob;

    }elseif($request->tipo_evaluador==2){
      $document->id_v2=$user_id;
      $document->v_2=$request->validation_document;
      $document->observ_2=$request->validation_document_ob;

    }elseif($request->tipo_evaluador==3){
      $document->id_v3=$user_id;
      $document->v_3=$request->validation_document;
      $document->observ_3=$request->validation_document_ob;

    }elseif($request->tipo_evaluador==777){
      $document->id_v1=$user_id;
      $document->v_1=$request->validation_document;
      $document->observ_1=$request->validation_document_ob;

      $document->id_v2=$user_id;
      $document->v_2=$request->validation_document;
      $document->observ_2=$request->validation_document_ob;

       $document->id_v3=$user_id;
      $document->v_3=$request->validation_document;
      $document->observ_3=$request->validation_document_ob;

    }else{
       return response()->json(['types'=>"supererror",'ms'=>'Lo sentimos pero usted no tiene permisos para evaluar']);
    }

    $document->save();
    return response()->json(['types'=>"success",'ms'=>'Documento evaluado!']);
  


  }




}
