<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    public static function allowedRoles():array
    {
        return [
             'manager', 
             'developer', 
             'design',
             'scrum master'
            ];
    }
}
