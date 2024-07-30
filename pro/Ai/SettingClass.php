<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/2/2019
 * Time: 10:26 AM
 */

namespace Pro\Ai;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        $configs = [
            'ai' => [
                'id'       => 'ai',
                'title'    => __("OpenAI Settings"),
                'position' => 20,
                'view'     => "Ai::admin.settings.ai",
                "keys"     => [
                    'ai_api_key',
                    'ai_model_name',
                ],
                'is_pro'   => true
            ]
        ];
        return $configs;
    }
}
