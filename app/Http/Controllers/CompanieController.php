<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\companie;
class CompanieController extends Controller
{


    public function index(){
        $available_companies=8;
        $companies= companie::where('status',true)->get();
        $available=8-($companies->count()) ;
        return view('system.companies.index')->with(compact('companies','available'));

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


}
