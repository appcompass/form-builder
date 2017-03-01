<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as GuzzleClient;
use P3in\Models\Video;

class VideosServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Video', Video::class);

        Video::deleted(function ($video) {
            switch ($video->storage) {
                case 'wistia':
                    $client = new GuzzleClient();
                    $response = $client->request('DELETE', "https://api.wistia.com/v1/medias/{$video->meta->hashed_id}.json", [
                        'form_params' => [
                            'api_password' => env('WISTIA_API_PASSWORD'),
                            'project_id' => env('WISTIA_PROJECT_ID'),
                        ]
                    ]);
                    $rtn = json_decode((string) $response->getBody());
                    break;
            }
            $video->galleryItem->delete();
        });
    }

    public function register()
    {
    }

    public function provides()
    {
        //
    }

}
