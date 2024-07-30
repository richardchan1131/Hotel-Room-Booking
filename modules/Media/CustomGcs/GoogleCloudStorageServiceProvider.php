<?php


namespace Modules\Media\CustomGcs;


use Google\Cloud\Storage\StorageClient;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Arr;

class GoogleCloudStorageServiceProvider extends \Spatie\GoogleCloudStorage\GoogleCloudStorageServiceProvider
{

    public function boot()
    {
        $factory = $this->app->make('filesystem');
        /* @var FilesystemManager $factory */
        $factory->extend('gcs', function ($app, $config) {
            $storageClient = $this->createClient2($config);

            $bucket = $storageClient->bucket($config['bucket']);
            $pathPrefix = Arr::get($config, 'path_prefix');
            $storageApiUri = Arr::get($config, 'storage_api_uri');

            $adapter = new CustomGoogleStorageAdapter($storageClient, $bucket, $pathPrefix, $storageApiUri);

            return $this->createFilesystem($adapter, $config);
        });
    }
    /**
     * Create a new StorageClient
     *
     * @param  mixed $config
     * @return \Google\Cloud\Storage\StorageClient
     */
    private function createClient2($config)
    {
        $keyFile = Arr::get($config, 'key_file_path');
        if (is_string($keyFile)) {
            return new StorageClient([
                'projectId' => $config['project_id'],
                'keyFilePath' => $keyFile,
            ]);
        }

        if (! is_array($keyFile)) {
            $keyFile = [];
        }
        return new StorageClient([
            'projectId' => $config['project_id'],
            'keyFile' => array_merge(["project_id" => $config['project_id']], $keyFile)
        ]);
    }
}
