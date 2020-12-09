<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

class GoogleHelpers{
    public static function glinkFoto($namaFile){
        $data = collect(Storage::disk('google')->listContents('/', false));
        $path = $data->where('name', $namaFile)->first()['path'];
        return "https://drive.google.com/uc?id=$path";
    }

    public static function getPathId($namaFile){
        $data = collect(Storage::disk('google')->listContents('/', false));
        $path = $data->where('name', $namaFile)->first()['path'];
        return env('GOOGLE_DRIVE_FOLDER_ID').'/'.$path;
    }
}
