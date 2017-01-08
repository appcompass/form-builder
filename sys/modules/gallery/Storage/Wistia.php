<?php

namespace P3in\Storage;

use P3in\BaseModule;

class Wistia
{

}

// logic that needs to be implemented.
// Video::deleted(function ($video) {
//     switch ($video->storage) {
//         case 'wistia':
//             $client = new GuzzleClient();
//             $response = $client->request('DELETE', "https://api.wistia.com/v1/medias/{$video->meta->hashed_id}.json", [
//                 'form_params' => [
//                     'api_password' => env('WISTIA_API_PASSWORD'),
//                     'project_id' => env('WISTIA_PROJECT_ID'),
//                 ]
//             ]);
//             $rtn = json_decode((string) $response->getBody());
//             break;
//     }
//     $video->galleryItem->delete();
// });
