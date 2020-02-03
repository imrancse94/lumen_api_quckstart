<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Repository\Repository as Repository;

class UsergroupController extends BaseController
{
    private $repository;

    function __construct(Repository $repository)
    {
        $this->repository = $repository;

    }

    public function getUserGroupList(){
       $usergroupList =  $this->repository->getUserGroupList();
       return $this->sendApiResponse(true,"Successfully get list",$usergroupList,config('apiconstants.API_LOGIN_SUCCESS'));
    }
}
