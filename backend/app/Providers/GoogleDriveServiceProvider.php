<?php

namespace App\Providers;

use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Nette\Utils\FileSystem;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('google', function($app, $config){
           $client = new \Google_Client();
           $client->setClientId($config['clientId']);
           $client->setClientSecret($config['clientSecret']);
           $client->refreshToken($config['refreshToken']);
           $service = new \Google_Service_Drive($client);
           $adatapter = new GoogleDriveAdapter($service, $config['folderId']);
           dd($adatapter);
           return new FileSystem($adatapter);
        });
    }
}
