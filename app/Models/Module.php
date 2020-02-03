<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Module extends Model
{
    protected $fillable = [
        'id', 'name', 'icon', 'sequence'
    ];
    public function getModules(){
        $modules = $this->all();

        return $modules;
    }


    public function submodules(){
       return $this->hasMany(\App\Models\Submodule::class);
    }


    public function getAllModuleSubmodulePagesAssoc(){
        $finalArray = [];
        $modules = DB::table('modules')
            ->select('modules.name as module_name','submodules.name as submodule_name',
                        'pages.name as page_name','modules.id as module_id','submodules.id as submodule_id',
                         'pages.id as page_id','pages.method_name as page_name','submodules.controller_name as controller_name'
                    )
            ->join('submodules', 'submodules.module_id', '=', 'modules.id')
            ->join('pages', 'pages.submodule_id', '=', 'submodules.id')
            ->get();

        foreach ($modules as $module){
            $current_pages[$module->submodule_id][] = ['page_name'=>$module->page_name];
            $current_submodule[$module->submodule_id] = ['submodule_name'=>$module->controller_name];
            $current_module[$module->module_id] = $module->module_name;
            $finalArray[$module->module_id][$module->submodule_id][$module->page_id] = 0;
        }

        $finalResult = [];
        foreach ($finalArray as $module_id => $final){
            $finalResult[$module_id] = ['module'=>$current_module[$module_id]];
            foreach ($final as $submodule_id => $submodule){
                $finalResult[$module_id]['submodule'] = $current_submodule[$submodule_id];
                $finalResult[$module_id]['submodule']['page'] = $current_pages[$submodule_id];
            }
        }


        dd($finalResult);
        return $finalArray;
    }


}
