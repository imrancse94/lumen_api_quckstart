<?php

namespace App\Http\Controllers\Traits;

use DB;
use App\Models\Module;
use RingCentral\SDK\Platform\Auth;
use Session;
use Config;
use Illuminate\Support\Facades\Route;
trait PermissionUpdateTreait
{
    public function getPermissionList($user_id)
    {
        $SUPER_SUPER_ADMIN_ID = Config::get('constants.defines.SSADMIN_ID');
        $sql = 'SELECT  users.id AS user_id,users.permission_version,pages.id AS page_id, pages.name AS page_name,
                                 modules.id AS module_id,submodules.controller_name,submodules.name AS submodule_name, submodules.id
                                 AS submodule_id,pages.route_name,submodules.default_method,pages.is_default_method FROM users
					INNER JOIN user_usergroups ON users.id = user_usergroups.user_id
					INNER JOIN usergroups ON user_usergroups.usergroup_id = usergroups.id
					INNER JOIN usergroup_roles ON usergroups.id = usergroup_roles.usergroup_id
					INNER JOIN roles ON usergroup_roles.role_id = roles.id
					INNER JOIN role_pages ON roles.id = role_pages.role_id
					INNER JOIN pages ON role_pages.page_id = pages.id
					INNER JOIN submodules ON pages.submodule_id = submodules.id
					INNER JOIN modules ON submodules.module_id = modules.id
					WHERE  users.id = ' . $user_id;

        $permissions = DB::select($sql);
        $moduleSubmodulePageAssoc = [];
        $masterArray = [1001, 1002, 1007];
        if (!empty($permissions)) {
            if(auth()->user()->id == 1){
                $modules = Module::with('submodules', 'submodules.pages')->get();
            }else{
                $modules = Module::with('submodules', 'submodules.pages')->whereNotIn('id',$masterArray)->get();
            }

            $moduleSubmodulePageAssoc = $this->getOrganizePermission($modules,$permissions);
        }

        return $moduleSubmodulePageAssoc;
    }


    private function getOrganizePermission($modules,$permissions){

        $result = [];
        $sideBarList = [];
        $permittedRouteName = $this->getPermittedPageRouteName($permissions);
        $moduleSubmodulePageAssoc = [];
        $permittedPageIdList = [];
        $sideBarPermittedPageIdList = [];
        $permittedModuleIdList = [];
        $permittedSubmoduleIdList = [];
        $defaultRouteList = [];
        foreach ($permissions as $perm){
            if(!empty($perm)) {
                $permittedPageIdList[] = $perm->page_id;
                $permittedModuleIdList[] = $perm->module_id;
                $permittedSubmoduleIdList[] = $perm->submodule_id;
                if ($perm->is_default_method == 1) {
                    $sideBarPermittedPageIdList[] = $perm->page_id;
                    $defaultRouteList[$perm->module_id] = $perm->route_name;
                }
            }
        }

        if(!empty($permittedModuleIdList) && is_array($permittedModuleIdList)){
            $permittedModuleIdList = array_unique($permittedModuleIdList);
        }

        if(!empty($permittedSubmoduleIdList) && is_array($permittedSubmoduleIdList)){
            $permittedSubmoduleIdList = array_unique($permittedSubmoduleIdList);
        }

        if(!empty($permittedPageIdList) && is_array($permittedPageIdList)){
            $permittedPageIdList = array_unique($permittedPageIdList);
        }

        if(!empty($sideBarPermittedPageIdList) && is_array($sideBarPermittedPageIdList)){
            $sideBarPermittedPageIdList = array_unique($sideBarPermittedPageIdList);
        }

        if(!empty($modules)){
            foreach ($modules as $m){
                if(in_array($m->id,$permittedModuleIdList)) {
                    $moduleName = strtolower(str_replace(" ","",$m->name));
                    $moduleSubmodulePageAssoc[$m->id]['name'] = $m->name;
                    $moduleSubmodulePageAssoc[$m->id]['icon'] = $m->icon;
                    $moduleSubmodulePageAssoc[$m->id]['url'] = $moduleName;
                    $sideBarList[$m->id]['id'] = $m->id;
                    $sideBarList[$m->id]['name'] = $m->name;
                    $sideBarList[$m->id]['icon'] = $m->icon;
                    $sideBarList[$m->id]['url'] = $moduleSubmodulePageAssoc[$m->id]['url'];

                    $pagesAssoc = [];
                    $sideBarPagesAssoc = [];
                    if (!empty($m->submodules)) {
                        foreach ($m->submodules as $submodule) {
                            //dd($submodule);
                            if(in_array($submodule->id,$permittedSubmoduleIdList)) {
                                $submoduleAssoc['id'] = $submodule->id;
                                $submoduleAssoc['name'] = $submodule->name;
                                $submoduleAssoc['icon'] = $submodule->icon;
                                $sideBarSubmodule = $submoduleAssoc;
                                $currentpages = [];
                                $currentSideBarpages = "";
                                if (!empty($submodule->pages)) {

                                    foreach ($submodule->pages as $page) {

                                        if (in_array($page->id, $permittedPageIdList)) {
                                            $current_page['id'] = $page->id;
                                            $current_page['name'] = $page->name;
                                            $current_page['route'] = $page->route_name;
                                            $currentpages[] = $current_page;
                                            if($page->id > 0 && in_array($page->id,$sideBarPermittedPageIdList)){
                                                $currentSideBarpages = $current_page['route'];
                                            }
                                        }
                                    }

                                    $sideBarSubmodule['url'] = $currentSideBarpages;
                                    $submoduleAssoc['pages'] = $currentpages;
                                    $pagesAssoc[] = $submoduleAssoc;
                                    $sideBarPagesAssoc[] = $sideBarSubmodule;
                                }
                            }
                        }
                        $moduleSubmodulePageAssoc[$m->id]['children'] = $pagesAssoc;
                        $sideBarList[$m->id]['children'] = $sideBarPagesAssoc;
                    }
                }
            }
        }



        $result['allpermissions'] = $moduleSubmodulePageAssoc;
        $result['routeList'] = $permittedRouteName;
        $result['sideBarList'] = $sideBarList;
        return $result;
    }

    private function getSideBarList($permissions)
    {
        $permittedRouteName = [];
        if(!empty($permissions)) {
            foreach ($permissions as $key => $permission) {
                $permittedRouteName[$key] = strtolower($permission->route_name);
            }
        }
        return $permittedRouteName;
    }

    private function getPermittedPageRouteName($permissions)
    {
        $permittedRouteName = [];
        foreach ($permissions as $key => $permission) {
            $permittedRouteName[$key] =  strtolower($permission->route_name);
        }
        return $permittedRouteName;
    }


    public function getSubModules($request_controller)
    {


        if ($request_controller == "dashboard") {
            return array();
        }
        $current_submodule_arr = array();
        $modules = Session::get('modules');
        if (!empty($modules)) {
            foreach ($modules as $module) {
                foreach ($module->submodules as $submodule) {

                    $submodule['controller_name'] = trim($submodule['controller_name']);
                    //echo $request_controller."=====".$submodule['controller_name']."<br/>";
                    if (strtolower($request_controller) == strtolower($submodule['controller_name'])) {
                        //echo "Sds";exit;
                        $current_submodule_arr = array($submodule['name'] => $submodule['id']);
                        break 2;
                    }
                }//exit;
            }
        }
        return $current_submodule_arr;
    }


    public function getPages($request_controller)
    {

        if ($request_controller == "dashboard") {
            return array();
        }
        $pages_arr = array();
        $current_submodule_arr = $this->getSubModules($request_controller);

        $modules = Session::get('modules');

        if (!empty($modules)) {
            foreach ($modules as $module) {
                foreach ($module->submodules as $submodule) {
                    if (current($current_submodule_arr) == $submodule['id']) {
                        foreach ($submodule['pages'] as $page) {
                            $pages_arr[$page['route_name']] = $page['id'];

                        }
                        break 2;
                    }
                }
            }
        }
        return $pages_arr;
    }


    public function verifyUser($auth_id, $db_user_id){
        $result  = false;
        if($auth_id == $db_user_id){
            $result  = true;
        }
        return $result;
    }

}
