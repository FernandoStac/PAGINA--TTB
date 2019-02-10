<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\role;
use App\companie;
use App\User;
use App\Access;

class UserController extends Controller
{	

    //show users
    public function index(){

        if(Access::canEnter("Ver usuarios")){

        	$roles=role::select('id','name')->where('id', '>',1)->get();
        	$companies=companie::select('id','name')->where('status',true)->get();

     
        	//dd(response()->json(['data'=>$users]));

        	return view('system/user/index')->with(compact('roles','companies'));
        }
        abort(401,"Lo sentimos, no tiene permisos para ver los usuarios");
    	
    }


    //get to see in a datable
    public function getUsers(){
    	$users=DB::table('users')
    		->select('users.id as id','users.name as userName','users.email as userEmail','companies.name as companieName','roles.name as roleName','users.companie_id','users.role_id')
    		->leftJoin("companies","users.companie_id",'=',"companies.id")
    		->leftJoin("roles","roles.id",'=',"users.role_id")
    		->where('role_id','!=','1')
    		->get();
    	return response()->json(['data'=>$users]);
    }


    //save a new user
    public function store(Request $request){
        $email=User::where('email',$request->email)->get();
        if(count($email)){
            return response()->json("rpt");
        }else{

            $role=role::where('id',$request->rol)->first();

    

            if($role->type=="admin"){
                User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                    'role_id'=>$request->rol,
                ]);

            }elseif($role->type=="provee"){
                User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role_id'=>$request->rol,
                'companie_id'=>$request->companie,
            ]);

            }


             return response()->json("Guardado con éxito");
        }
    }


    //update a user
    public function update(Request $request){

        if(Access::canEnter("Editar usuarios")){
            $user=User::find($request->iduser);
            $email=User::where('email',$request->email2)
                        ->where('id',"!=",$user->id)
                        ->get();
            if(count($email)){
                return response()->json("rpt");
            }else{
                $user->email=$request->email2;
                $user->name=$request->name2;
                $user->save();
                 return response()->json("Guardado con éxito");
            }
        }
        return response()->json("Sin permisos para actualizar un usuario");
    }
}
