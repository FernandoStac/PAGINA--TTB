<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    public function getUrl2Attribute(){
    	

    	return '/images/documents/'.$this->document;

    }


    public function user()
    {
      //return $this->belongsTo('App\role');
      return $this->belongsTo('App\User');
    }


     public function companie()
    {
      //return $this->belongsTo('App\role');
      return $this->belongsTo('App\companie');
    }


     public function getCompanieNameShortAttribute()
    {
      //return $this->belongsTo('App\role');
      return $this->companie->name_short;
    }



    public function getCompanieIdAttribute()
    {
      //return $this->belongsTo('App\role');
      return $this->companie->id;
    }



    public function getNameUserAttribute(){
            return $this->user->name;

    }

}
