<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ApiResponseTrait;
use App\Http\Controllers\Traits\PermissionUpdateTreait;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ApiResponseTrait, PermissionUpdateTreait;
}
