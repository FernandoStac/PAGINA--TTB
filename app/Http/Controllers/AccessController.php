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
		->select('description_accesses.id as id','description_accesses.name as name','menus.name as nameMenu','menus.id as idmenu')
		->leftJoin("menus","menus.id",'=',"description_accesses.menu_id")
		->where('description_accesses.enabled','1')
		 
		->get();
		return response()->json(['data'=>$access]);

    }


    public function store(Request $request){
        $access=DescriptionAccess::where('name',$request->name)->get();
        if(count($access)){
            return response()->json("El permiso ya existe");
        }else{


                DescriptionAccess::create([
                'name'=>$request->name,
                'menu_id'=>$request->menuvalue,
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
            $role->save();
            return response()->json("1");
        
    }
}
