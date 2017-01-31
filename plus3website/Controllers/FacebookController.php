<?php

namespace P3in\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Facebook\Facebook;

class FacebookController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $fb;

    public function getFeed(Request $request)
    {
        $this->init();

        $details = $this->getPageDetails();
        $feed = $this->getPageFeed();

        $rtn = [
            'name' => $details->name,
            'picture' => $details->picture->data->url,
            'fan_count' => $details->fan_count,
            'rating_count' => $details->rating_count,
            'were_here_count' => $details->were_here_count,
        ];

        foreach ($feed->data as $row) {
            $rtn['feed'][] = [
                'message' => isset($row->message) ? $row->message : '',
                'description' => isset($row->description) ? $row->description : '',
                'full_picture' => isset($row->full_picture) ? $row->full_picture : '',
                'reactions' => isset($row->reactions) ? count($row->reactions->data) : 0,
                'actions' => !empty($row->actions) ? $row->actions : [],
            ];
        }

        return response()->json($rtn);
    }

    public function getOauthRedirect(Request $request)
    {
        //@TODO: add endpoint so we can re-auth a token for the app.
    }

    public function getDeauthCallback(Request $request)
    {
        //@TODO: add endpoint so we can re-auth a token for the app.
    }

    private function init()
    {
        $this->fb = new Facebook([
            'app_id' => getenv('FACEBOOK_APP_ID'),
            'app_secret' => getenv('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.8',
            // good till March, need to find a way to keep it renewed 100% from the server.
            'default_access_token' => 'EAARvabruDb0BAJuseJBsqjKWx0fWw5qQYqQBsk4ZAcA2p4HiCd5mbevhcli1tIvvFeVMSKFCw7LGnz8cTkZBV2lmZBkjLPov6ZCGYwsTCWInt4w5Py49OziXbz0FV2kK07r06mlxkSWi15ffseV7GlYfRi58jZAAZD'
        ]);
    }

    private function getLongLivedToken($token)
    {
        // $oAuth2Client = $fb->getOAuth2Client();

        // $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($token);

        // dd($longLivedAccessToken);
    }

    private function getPageDetails()
    {
        return $this->makeRequest('get', '/Plus3Interactive', [
            'fields' => 'name,picture,fan_count,rating_count,were_here_count',
        ]);
    }

    private function getPageFeed()
    {
        return $this->makeRequest('get', '/Plus3Interactive/feed', [
            'fields' => 'actions,description,reactions,full_picture,message',
        ]);
    }

    private function makeRequest(string $method, string $endpoint, array $options = [])
    {
        try {
            $req = $this->fb->sendRequest($method, $endpoint, $options);

            return json_decode($req->getBody());

        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            throw new Exception('Graph returned an error: ' . $e->getMessage());
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            throw new Exception('Facebook SDK returned an error: ' . $e->getMessage());
        }

    }
}
