<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageOptimize extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getImageOptimize($values = []){
        $records = self::whereRaw('1=1');
        if(isset($values['module_name'])) {
$records->where('module_name',$values['module_name']);
        }
        $records = $records->get()->toArray();

        $new_array = array();
        $thumbs = array();
        $count = 0;
        foreach ($records as $key => $value) {
            $thumbs[(isset($values['module_name']) && !isset($values['c_int']) ? $value['thumb_folder'] : $count)] = array(
                'thumb_folder' => $value['thumb_folder'],
                'width' => $value['width'],
                'height' => $value['height'],
                'is_optimise' => $value['is_optimise'],
                'id' => $value['id'],
            );
            $count = $count + 1;
            if (!isset($records[$key + 1])) {
                $records[$key + 1]['module_name'] = "";
            }
            if ($records[$key + 1]['module_name'] != $value['module_name']) {
                $type = '';
                if ($value['width'] == '') {
                    $type = 'height';
                } elseif ($value['height'] == '') {
                    $type = 'width';
                } else {
                    $type = 'cropper';
                }
                $new_array[] = array(
                    'crop_ratio' => $value['crop_ratio'],
                    'module_name' => $value['module_name'],
                    'thumbs' => $thumbs,
                    'type' => $type
                );
                $thumbs = array();
                $count = 0;
            }
        }
        return $new_array;
        // $i_o_array = $new_array;
    }

    public static function saveImageSize() {
        $image_opt = self::getImageOptimize();

        $image_array = [];
        foreach($image_opt as $image) {
            foreach($image['thumbs'] as $thumb) {
                $image_array[$image['module_name']][$thumb['thumb_folder']] = $thumb['width'] .' X '.$thumb['height'];
            }
        }
        file_put_contents(base_path() .'/config/imageSize.php',  '<?php return ' . var_export($image_array, true) . ';');
    }
}
