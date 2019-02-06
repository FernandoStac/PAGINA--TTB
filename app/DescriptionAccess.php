<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescriptionAccess extends Model
{
     protected $fillable = [
        'name', 'menu_id','enabled'
    ];
}
