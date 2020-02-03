<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUsergroup extends Model
{
    protected $fillable = [
        'usergroup_id', 'user_id','company_id'
    ];
}
