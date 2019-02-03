<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Menu;

class MenuController extends Controller
{
     public function index(){
    	return view('system/menus/index');
    	
    }

     public function get(){

     		    	$users=DB::table('menus')
    		->select('menus.id as id','menus.name as name','menus.slug as route','menus.order as order')
    		->where('enabled','1')
    		 ->orderby('order')
    		->get();
    	return response()->json(['data'=>$users]);

    }

    public function getMenu(){
    	try {
    	$menus=DB::table('menus')
    		->select('menus.id as val','menus.name as text')
    		->where('enabled','1')
            ->where('id','<>','1')
    		 ->orderby('order')
    		->get();
    	return response()->json(['data'=>$menus]);
    	} catch (Exception $e) {
     			return	response()->json($e->errorInfo);
     	}
    }





  
    public function update(Request $request){
		if(is_null($request->name) or $request->name==""){
			            return response()->json("Los campos estan vacios");
		}

        $menu=Menu::find($request->id);

            $menu->name=$request->name;
            $menu->slug=$request->route;
            $menu->order=$request->order;
            $menu->save();
            return response()->json("1");
        
    }


    public function store(Request $request){
        $menu=Menu::where('name',$request->name)->get();
        if(count($menu)){
            return response()->json("El menu ya existe");
        }else{


                Menu::create([
                'name'=>$request->name,
                'slug'=>$request->route,
                'order'=>$request->order,
                 ]);
  

             return response()->json("1");
        }
    }
}
