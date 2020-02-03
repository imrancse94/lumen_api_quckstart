<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submodule extends Model
{
    protected $fillable = [
        'id', 'module_id','name', 'icon', 'sequence','controller_name','favicon_path','default_method'
    ];

    public function pages()
    {
        return $this->hasMany(\App\Models\Page::class);
    }

    public function modules() {
        return $this->hasOne(\App\Models\Module::class,'id', 'module_id');
    }
    public function getSubModules(){
        $submodules = $this->all();

        return $submodules;
    }

    public function getPages(){
        return $this->belongsTo('\App\Models\Page', 'sub_module_id');
    }
}
