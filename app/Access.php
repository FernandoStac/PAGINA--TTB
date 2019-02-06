<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Access extends Model
{
     protected $fillable=['description_accesses_id','role_id'];






    public static function canEnter($da)
    {
         $id=Auth::user()->role_id;

        $accesses=DB::table('description_accesses')
        ->select(DB::raw('description_accesses.[id] as [id]'))
        ->Join(DB::raw("(select * from accesses a where a.role_id=".$id.") as a"), 'description_accesses.id', '=', 'a.description_accesses_id')->where("name","=",$da)
         ->get();



	      if(count($accesses) or $id==1){
	            $available_companies=8;
	            $companies= companie::where('status',true)->get();
	            $available=8-($companies->count()) ;
	            return true;

         }else{
             return false;
         }

    }
}
