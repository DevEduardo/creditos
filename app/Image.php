<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use File;
use Exception;

class Image extends Model
{
    
    public static function saveImage ($image, $destination, $imageToDelete = null)
    {
		try {
        	$random 	= str_random(6);
	    	$filename	= trim($random . $image->getClientOriginalName());

            if(isset($imageToDelete) && $imageToDelete != 'avatar.png') {
                File::delete($destination . $imageToDelete);
            }

	    	$image->move($destination, $filename);
	    	
        } catch (Exception $e) {
            #dd($e);
            throw_if(true, Exception::class, "Ocurrió un error al guardar la imagen, intenta nuevamente!");
        }

        return $filename;
	    
    }

    public static function deleteImage($image, $destination)
    {
        try{
            if (isset($image) && ($image !== 'avatar.png')) {
                File::delete($destination . $image);    
            }
            
        } catch (Exception $e) {
            throw_if(true, Exception::class, "Ocurrió un error al eliminar, intenta nuevamente!");
        }                       
    }

}
