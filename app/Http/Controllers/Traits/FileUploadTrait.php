<?php
namespace App\Http\Controllers\Traits;


use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function uploadFile($file, $path)
    {
        //dd($path);
        $extension = $file->getClientOriginalExtension();
        $sha = sha1($file->getClientOriginalName());
        $filename = date('Y-m-d-h-i-s')."-".$sha.".".$extension;

        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $file->move($path, $filename);
        //Storage::put($path, $filename);
        return $path.$filename;
    }

    public function filewrite($file_name,$directory,$content){
        $result = false;

        try {
            if (!empty($file_name) && !empty($directory) && !empty($content)) {
                Storage::disk('local')->put($directory."/".$file_name, utf8_encode($content));
                $result = true;
            }

        }catch (Exception $e){
            $error = $e->getMessage();
            dd($error);
        }

        return $result;

    }

    public function getAllPermissions(){
        $result = [];
        if(Auth::check()){
            $auth_id = Auth::id();
            $file = $auth_id."/".$auth_id.".json";
            $content = Storage::disk('local')->get($file);
            $permission = json_decode($content,true);
            if(!empty($permission)){
                $result = $permission;
            }
        }

        return $result;
    }




}
