<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\role;
use App\Access;
class RoleController extends Controller
{

    public function index(){
        if(Access::canEnter("Ver roles")){
            return view('system/roles/index');
        }
        abort(401,"Lo sentimos, no tiene permisos para ver los Roles");
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


        if(Access::canEnter("Editar Rol")){
    		if(is_null($request->role2) or $request->role2==""){
    			            return response()->json("Los campos estan vacios");
    		}

            $role=role::find($request->idrole);

                $role->name=$request->role2;
                $role->type=$request->tipo2;
                $role->save();
                return response()->json("1");
        }
        return response()->json("Sin permisos para editar un Rol");
        
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

        if(Access::canEnter("Eliminar Rol")){

            	try {

            		         $id=$request ->input('id');

                $notification="No fue posible eliminar el  documento, no existe o esta siendo utilizado :(";
                $role=role::find($id);
                if(is_null($role)){

                   return response()->json("El ya no existia.");
                }  

                
                $role->delete();
                $notification="El rol fue eliminado fue eliminada";
             
                 return response()->json($notification);
            		
            	} catch (\Illuminate\Database\QueryException $e) {
            		return response()->json($e->errorInfo[0]);
            	}
        }

        return response()->json("Sin permisos para eliminar :)");

    }


    public function access_view($id){

        if(Access::canEnter("Permisos del Role")){

            $accesses=DB::table('description_accesses')
            ->select(DB::raw('description_accesses.[id] as [id], description_accesses.[name] as [name] ,iif(a.role_id is null,0,1)estatus ,menus.name as [namemenu]'))
            ->leftjoin(DB::raw("(select * from accesses a where a.role_id=".$id.") as a"), 'description_accesses.id', '=', 'a.description_accesses_id')
                ->leftjoin('menus', 'menus.id', '=', 'description_accesses.menu_id')
                ->where('description_accesses.enabled',"true")
                ->orderBy('menus.name')
             ->get();
     


            $role= role::where('id',$id)->where("id","<>","1")->first();
            if(is_null($role)){
                abort(401);
            }

            return view('system/roles/role_access')->with(compact('role','accesses'));;
        }

             abort(401,"Lo sentimos, no tiene permisos para dar permisos al role");

    }



    

}
