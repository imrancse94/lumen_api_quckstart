<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Companyaddrequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class CompanyController extends BaseController
{

    public function addCompany(Companyaddrequest $request){
            $inputData = $request->all();


    }
}
