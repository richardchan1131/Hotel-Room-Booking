<?php


namespace Modules\Media;


use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{

    public static function getSettingPages()
    {
        return [
            'media'=>[
                'id'=>'media',
                'title' => __("Media Settings"),
                'view'      => "Media::admin.settings.file-system",
                'position'=>85,
                "keys"=>[
                    'filesystem_default',
                    'filesystem_s3_key',
                    'filesystem_s3_secret_access_key',
                    'filesystem_s3_region',
                    'filesystem_s3_bucket',

                    'gcs_project_id',
                    'gcs_bucket',
                    'gcs_key_file',
                ]
            ]
        ];
    }
}
