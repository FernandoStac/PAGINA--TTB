<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MyResetPassword;

class User extends Authenticatable
{




    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id','companie_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function role()
    {
      //return $this->belongsTo('App\role');

      return $this->belongsTo('App\role');
    }


     public function companie()
    {
      //return $this->belongsTo('App\role');

      return $this->belongsTo('App\companie');
    }


     public function getRoleNameAttribute()
    {
      //return $this->belongsTo('App\role');
      return $this->role->name;
    }


     public function getCompanieNameAttribute()
    {
      //return $this->belongsTo('App\role');
      return $this->companie->name;
    }


}
