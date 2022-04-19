<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        try{
            $message = (unlink(public_path($image->url))) ?
                'Imagen eliminada con éxito' :
                'No se pudo eliminar la imagen';

            $image->delete();

            return response()->json([
                'message' => 'Imagen eliminada con éxito',
                'public_path' => public_path($image->url),
                'path' => $image->url

            ]);
        } catch (Exception $ex){
    
            $image->delete();
            
            return response()->json([
                'message' => 'No se encontró la imagen'
            ]);
        }
    }
}
