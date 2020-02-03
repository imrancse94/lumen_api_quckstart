<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index(){
       // echo Storage::getVisibility('public/dist/img/AdminLTELogo.png');;exit;
        //Storage::url('/app/public/dist/img/AdminLTELogo.png');
        echo '<img src='.url('/storage/dist/img/AdminLTELogo.png').'>';exit;
    }
    //
}
