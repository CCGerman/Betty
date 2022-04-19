<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;



class UploaderHelper {

    const UPLOAD_PATH = 'public/images';

    public static function uploadImage(UploadedFile $image){

        $path = Storage::put(UploaderHelper::UPLOAD_PATH, $image);

        return Storage::url($path);

    }


}