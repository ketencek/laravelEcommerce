<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function saveConfig() {
        $settings = self::where('status', 1)->pluck('value','name')->toArray();
        file_put_contents(base_path() .'/config/settingconfig.php',  '<?php return ' . var_export($settings, true) . ';');
    }
}
