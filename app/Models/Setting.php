<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public static function updateSettings($workspace_id,$key,$value)
    {

        $setting = self::where('key',$key)->first();

        if($setting)
        {
            $setting->value = $value;
            $setting->save();
        }
        else{
            $setting = new Setting();

            $setting->workspace_id = $workspace_id;
            $setting->key = $key;
            $setting->value = $value;

            $setting->save();
        }


    }
}
