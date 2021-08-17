<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Carbon\Carbon;
use Image;
use File;
use App\Models\ImageOptimize;

class ImageHelper
{
    public static function saveUploadedImage($file, $module_name, $storagePath, $fileOldName = '')
    {
        // echo $fileOldName;
        // exit;
        $thumb_folders = ImageOptimize::where('module_name', $module_name)->get()->toArray();

        $randomStringTemplate = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle(str_repeat($randomStringTemplate, 5)), 0, 5);

        $timestamp = Carbon::createFromFormat('U.u', microtime(true))->format("YmdHisu");
        $nameWithoutExtension = preg_replace("/[^a-zA-Z0-9]/", "", '') . '' . $timestamp;
        $nameWithoutExtension = $nameWithoutExtension . '-' . $randomString;
        $fileExtension = $file->getClientOriginalExtension();
        $name = $nameWithoutExtension . '.' . $fileExtension;
        $name = str_replace([' ', ':', '-'], "", $name);

        $deleteFileList = array();
        $thumbName = "";

        $img = Image::make($file->getRealPath());
        $original_save = $img->save($storagePath .'original/'. $name);
        if ($original_save) {
            foreach ($thumb_folders as $thumb) {
                $thumb_name = $thumb['thumb_folder'];
                $height = $thumb['height'];
                $width = $thumb['width'];
                try {
                    $thumbnailStoragePath = $storagePath . $thumb_name . "/";
                    $img = Image::make($file->getRealPath())->resize($width, $height);
                    $img->save($thumbnailStoragePath . $name);
                } catch (\Exception $e) {
                    // $returnArray = array('name' => "", "error_msg" => $e . getMessage());
                    // return $returnArray;
                }
            }
        }

        
        if ($fileOldName != '') {
            ImageHelper::deleteModuleMultipleImage($fileOldName, $storagePath);
        }
        // if ($fileOldName != '') {
        //     $deleteFileList[] = $storagePath . $fileOldName;
        //     foreach ($thumb_folders as $thumb) {
        //         $deleteFileList[] = $storagePath . "thumb/" . $fileOldName;
        //     }
            
        // }

        // if (count($deleteFileList) > 0) {
        //     ImageHelper::deleteIfFileExist($deleteFileList);
        // }




        return $name;
    }

    public static function deleteIfFileExist($files)
    {
        if (is_array($files) && count($files) > 0) {
            foreach ($files as $key => $path) {
                if (!empty($path) && File::exists($path)) {
                    unlink($path);
                }
            }
        } else {
            if (!empty($files) && File::exists($files)) {
                unlink($files);
            }
        }
    }

    public static function deleteModuleMultipleImage($file, $folder_name)
    {
        $image_type =  config('customconfig.image.thumb_folder');

        foreach ($image_type  as $image) {
            
            $path = $folder_name . $image . '/' . $file;
            if (!empty($path) && File::exists($path)) {
                unlink($path);
            }
        }

        $files = $folder_name .'original/'. $file;
        if (!empty($files) && File::exists($files)) {
            unlink($files);
        }

        $files1 = $folder_name . $file;
        if (!empty($files1) && File::exists($files1)) {
            unlink($files1);
        }
    }

    public static function uploadFile($file, $storagePath) {
        
        $randomStringTemplate = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle(str_repeat($randomStringTemplate, 5)), 0, 5);

        $timestamp = Carbon::createFromFormat('U.u', microtime(true))->format("YmdHisu");
        $nameWithoutExtension = preg_replace("/[^a-zA-Z0-9]/", "", '') . '' . $timestamp;
        $nameWithoutExtension = $nameWithoutExtension.'-'.$randomString;
        $fileExtension = $file->getClientOriginalExtension();
        $name = $nameWithoutExtension. '.' . $fileExtension;
        $name = str_replace([' ', ':', '-'], "", $name);

        $deleteFileList = array();
        try {
            $returnArray = array('name' => "", "error_msg" => __("Sorry something went wrong please try again"));
            if($file->move($storagePath,$name)) {

                $returnArray = array('name' => $name, "error_msg" => "");
            }
            return $returnArray;

        } catch (\Exception $e) {
            $returnArray = array('name' => "", "error_msg" => $e->getMessage());
            return $returnArray;
        }
    }
}
