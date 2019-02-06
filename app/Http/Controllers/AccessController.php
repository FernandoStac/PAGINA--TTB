<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use App\Access;
use App\DescriptionAccess;

class AccessController extends Controller
{
     public function index(){
    	return view('system/accesses/index');
    	
    }


     public function get(){

 		 $access=DB::table('description_accesses')
		->select('description_accesses.id as id','description_accesses.name as name','menus.name as nameMenu','menus.id as idmenu','description_accesses.enabled as dispo')
		->leftJoin("menus","menus.id",'=',"description_accesses.menu_id")
		//->where('description_accesses.enabled','1')
		 
		->get();
		return response()->json(['data'=>$access]);

    }


    public function store(Request $request){
        if(is_null($request->name) or $request->name==""){
                        return response()->json("Los campos estan vacios");
        }
        $access=DescriptionAccess::where('name',$request->name)->get();
        if(count($access)){
            return response()->json("El permiso ya existe");
        }else{


                DescriptionAccess::create([
                'name'=>$request->name,
                'menu_id'=>$request->menuvalue,
                'enabled'=>$request->disponible
                 ]);
  

             return response()->json("1");
        }
    }




    public function update(Request $request){
		if(is_null($request->name) or $request->name==""){
			            return response()->json("Los campos estan vacios");
		}

        $role=DescriptionAccess::find($request->id);

            $role->name=$request->name;
            $role->menu_id=$request->menuvalue;
            $role->enabled=$request->disponible;
            $role->save();
            return response()->json("1");
        
    }


    public function update_to_role(Request $request){


         $access=DB::table('accesses')
         ->where('description_accesses_id',"=",$request->id)
        ->where("role_id","=",$request->id_role)->first();

        if(!is_null($access)){
            $this->destroy($access->id);
                return response()->json("0");
        }{
            $this->create($request->id,$request->id_role);
            return response()->json("1");
        }

        
    }


    public function create($da,$role){
         Access::create([
                'description_accesses_id'=>$da,
                'role_id'=>$role
                 ]);
    }


    public function destroy($id){
        $role=Access::find($id);        
        $role->delete();
    }
}



