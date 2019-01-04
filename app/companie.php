<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class companie extends Model
{
    protected $fillable=['name','name_short','email'];

    use Notifiable;



     public function user()
    {
      //return $this->belongsTo('App\role');
      return $this->hasMany('App\user');
    }
}
