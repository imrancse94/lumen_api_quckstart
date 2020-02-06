<?php

namespace App\Http\Controllers;


use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(UserRepository $userRepository){
        $this->repository = $userRepository;
    }

    public function userAdd(UserRequest $request){
        $inputData = $request->all();
        $inputData['company_id'] = auth()->user()->company_id;
        $status_code = config('apiconstants.API_USER_ADD_FAILED');
        $description = "Not inserted";
        $status = false;
        $data = [];
        DB::beginTransaction();
        try {
            $data = $this->repository->addNewUser($inputData);
            if (!empty($data)) {
                $status = true;
                $description = "Successfully inserted";
                $status_code = config('apiconstants.API_USER_ADD_SUCCESS');
            }
            DB::commit();
        }catch (\Exception $e){
            $description = $e->getMessage();
            DB::rollback();
        }

        return $this->sendApiResponse($status, $description , $data, $status_code);
    }

    public function userList(Request $request){

        $status_code = config('apiconstants.API_USER_LIST_FAILED');
        $description = "No data found";
        $status = false;
        $inputData = $request->all();
        $data = $this->repository->getUserList($inputData);
        if(!empty($data)){
            $description = "user list";
            $status = true;
            $status_code = config('apiconstants.API_SUCCESS');
        }
        $response = $this->sendApiResponse($status, $description , $data, $status_code);
        return $response;
    }


    public function delete($id){
        $status_code = config('apiconstants.USER_DELETE_FAILED');
        $description = "No data deleted";
        $status = false;
        $data = $this->repository->userDeleteById($id);
        if(!empty($data)){
            $description = "user deleted";
            $status = true;
            $status_code = config('apiconstants.API_SUCCESS');
        }

        $response = $this->sendApiResponse($status, $description , $data, $status_code);
        return $response;
    }


}
