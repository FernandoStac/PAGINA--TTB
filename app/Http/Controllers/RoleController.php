<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\role;
class RoleController extends Controller
{

    public function index(){
    	return view('system/roles/index');
    	
    }


    public function getRoles(){
    	$users=DB::table('roles')
    		->select('roles.id as id','roles.name as name','roles.type as tipo')
    		->where('id','!=','1')
    		->get();
    	return response()->json(['data'=>$users]);
    }



    //update a role
    public function update(Request $request){
		if(is_null($request->role2) or $request->role2==""){
			            return response()->json("Los campos estan vacios");
		}

        $role=role::find($request->idrole);

            $role->name=$request->role2;
            $role->type=$request->tipo2;
            $role->save();
            return response()->json("1");
        
    }



        //save a new role
    public function store(Request $request){
        $role=role::where('name',$request->role2)->get();
        if(count($role)){
            return response()->json("El role ya existe");
        }else{


                role::create([
                'name'=>$request->role2,
                'type'=>$request->tipo2
                 ]);
  

             return response()->json("1");
        }
    }



    public function destroy(Request $request){

    	try {

    		         $id=$request ->input('id');

        $notification="No fue posible eliminar el  documento, no existe o esta siendo utilizado :(";
        $role=role::find($id);
        if(is_null($role)){

           return response()->json("La empresa ya no existia.");
        }  

        
        $role->delete();
        $notification="El rol fue eliminado fue eliminada";
     
         return response()->json($notification);
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		return response()->json($e->errorInfo[0]);
    	}


    }

}
