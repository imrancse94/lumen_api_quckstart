<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function add($inputdata){
        return Company::create($inputdata);
    }
}
