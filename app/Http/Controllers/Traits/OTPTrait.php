<?php
namespace App\Http\Controllers\Traits;

trait OTPTrait{
 public function sendOTP(){


}

public function cacheTheOTP()
    {
        $OTP = rand(100000, 999999);

        return $OTP;
    }

}
