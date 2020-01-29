<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Auth;

trait ApiResponseTrait
{
    public function sendApiResponse($status,$description, $data = [], $statusCode) {

        $response = [
            'success'=>$status,
            'isAuthenticated'=> Auth::check(),
            'statuscode' => $statusCode,
            'description' => $description,
            'data'=>$data
        ];


        return response()->json($response, 200);
    }



}
