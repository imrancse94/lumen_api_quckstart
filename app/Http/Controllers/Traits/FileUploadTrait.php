<?php
namespace App\Http\Controllers\Traits;


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
                $directory = "storage/".$directory;
                if (!is_dir($directory)) {
                    mkdir($directory,0777,true);
                }
                $directory .= "/".$file_name;
                $file = fopen($directory,'w+');
                fwrite($file,utf8_encode($content));
                fclose($file);
                $result = true;
            }

        }catch (\Exception $e){
            $error = $e->getMessage();

        }

        return $result;

    }

    public function getAllPermissions(){
        $result = [];
        if(auth()->check()){
            $auth_id = auth()->user()->id;
            $file = "storage/".$auth_id."/".$auth_id.".json";
            $content = file_get_contents($file);
            $permission = json_decode($content,true);
            if(!empty($permission)){
                $result = $permission;
            }
        }

        return $result;
    }




}
