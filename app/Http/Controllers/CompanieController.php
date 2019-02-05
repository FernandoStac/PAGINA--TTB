<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\companie;
class CompanieController extends Controller
{


    public function index(){
        $id=Auth::user()->role_id;

        $accesses=DB::table('description_accesses')
        ->select(DB::raw('description_accesses.[id] as [id]'))
        ->Join(DB::raw("(select * from accesses a where a.role_id=".$id.") as a"), 'description_accesses.id', '=', 'a.description_accesses_id')->where("name","=","Ver empresas")
         ->get();



         if(count($accesses) or $id==1){
                $available_companies=8;
                $companies= companie::where('status',true)->get();
                $available=8-($companies->count()) ;
                return view('system.companies.index')->with(compact('companies','available'));

         }else{
             abort(401);
         }



    }

    public function store(Request $request){
    	$companie= new companie ();
        $companie->name=$request->name;
        $companie->name_short=$request->name_short;
        $companie->email=$request->email;
        $companie->save();
    	
		return redirect('/system/companie');

    }

    public function update(Request $request, $id){
        $companie=companie::find($id);
        $companie->name=$request->input('name');
        $companie->email=$request->input('email');
        $companie->save();
        
        return back();

    }



    public function destroy(Request $request){
         $id=$request ->input('id');

        $notification="No fue posible eliminar el  documento, no existe o esta siendo utilizado :(";
        $companrs=companie::find($id);
        if(is_null($companrs)){

           return response()->json("La empresa ya no existia.");
        }  

        
        $companrs->delete();
        $notification="La empresa fue eliminada";
     
         return response()->json($notification);

    }


}
