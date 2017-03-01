<?php

namespace P3in\Storage;

// we really need to make this into a filesystem adapter.
class Wistia
{
    private $api_password;
    private $project_id;
    private $multipart;

    public function __construct($project_id, $password)
    {
        $this->multipart = false;
        $this->project_id = $project_id;
        $this->password = $password;
    }

    public function store($name, $path, $url = false)
    {
        if ($url) {
            $payload = [
                'name' => $name,
                'url' => $path,
            ];
        } else {
            $this->multipart = false;
            $payload = [
                [
                    'name'     => 'name',
                    'contents' => $name
                ],[
                    'name'     => 'file',
                    'contents' => fopen($path, 'r')
                ]
            ];
        }

        return $this->request('POST', 'https://upload.wistia.com/', $payload);
    }

    public function delete($hashed_id)
    {
        return $this->request('DELETE', 'https://api.wistia.com/v1/medias/'.$hashed_id.'.json');
    }

    public function getInfo($hashed_id)
    {
        return $this->request('GET', 'https://api.wistia.com/v1/medias/'.$hashed_id.'.json');
    }


    private function request($type, $path, $params = [])
    {
        if ($this->multipart) {
            $payload = [
                'multipart' => array_merge_recursive([
                    [
                        'name'     => 'api_password',
                        'contents' => env('WISTIA_API_PASSWORD')
                    ],[
                        'name'     => 'project_id',
                        'contents' => env('WISTIA_PROJECT_ID')
                    ]
                ], $params),
            ];
        } else {
            $payload = [
                'form_params' => array_merge_recursive([
                    'api_password' => $this->password,
                    'project_id' => $this->project_id,
                ], $params),
            ];
        }
        $client = new GuzzleClient();
        $response = $client->request('DELETE', $path, $payload);

        return json_decode((string) $response->getBody());
    }
}
