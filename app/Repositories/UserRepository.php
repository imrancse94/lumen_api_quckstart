<?php

namespace App\Repositories;


use App\Models\Company;
use App\Repositories\Eloquent\Repository;

class UserRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\User';
    }

    public function setPermissionByUserId($user_id){
        return $this->getPermissionList($user_id);
    }

    public function addNewUser($inputData){
        return $this->model()->insertUser($inputData);
    }

    public function getUserList($inputData){
        return $this->getCurrentModel()->getUserList($inputData);
    }

    public function userDeleteById($id){
        return  $this->model()->userDeleteById($id);
    }

    public function processCompanyAdd($inputData){
        $companyObj = new Company();
        $company = $companyObj->add($inputData);
        $inputData['username'] = $inputData['name'];
        $inputData['company_id'] = $company->id;
        $this->addNewUser($inputData);
    }
}
