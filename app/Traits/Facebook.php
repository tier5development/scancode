<?php

namespace App\Traits;

use App\Models\User;
use Facebook\Exceptions\FacebookExceptionsFacebookResponseException;
use Facebook\Exceptions\FacebookExceptionsFacebookSDKException;
use Facebook\Facebook as Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

trait Facebook
{
    /**
     * Facebook Pages Array
     *
     * @var array
     */
    private $pages = [];

    /**
     * The Facebook Client
     *
     * @var Facebook
     */
    private $client;

    /**
     * The trait constructor
     */
    public function __construct() {
        $this->client = new Client([
            'app_id' => config("services.facebook.client_id"),
            'app_secret' => config("services.facebook.client_secret"),
            'default_graph_version' => "v" . config("services.facebook.api_version"),
        ]);
    }

    /**
     * Get all Facebook pages of an user
     *
     * @param User $user
     * @param string $paging
     * @return array
     */
    public function getAllPages(User $user, string $paging = null)
    {
        $after = !is_null($paging) ? "&after=$paging" : "";
        if (is_null($paging)) $this->pages = [];

        try {
            $response = $this->client->get(
                "/{$user->facebook_id}/accounts?fields=page_token{$after}",
                $user->remember_token
            );
            $feedEdge = $response->getGraphEdge();
            foreach ($feedEdge as $node) {
                array_push($this->pages, $node->asArray());
            }
            if ($cursor = $this->handlePagination($feedEdge->getMetaData())) {
                $this->getAllPages($user, $cursor['after']);
            }
        } catch (FacebookExceptionsFacebookResponseException $e) {
            Log::error($e->getMessage());
        } catch (FacebookExceptionsFacebookSDKException $e) {
            Log::error($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return $this->pages;
    }

    public function generatePageAccessToken(string $token, int $pageId)
    {
        try {
            $response = $this->client->get(
                "/{$pageId}?fields=access_token",
                $token
            );
            return $response->getGraphNode()->asArray();
        } catch (FacebookExceptionsFacebookResponseException $e) {
            Log::error($e->getMessage());
        } catch (FacebookExceptionsFacebookSDKException $e) {
            Log::error($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function generateMessengerScanCode($pageAccessToken)
    {
        try {
            $response = $this->client->get(
                "/me/messenger_codes",
                $pageAccessToken
            );
            return $response->getGraphNode()->asArray();
        } catch (FacebookExceptionsFacebookResponseException $e) {
            Log::error($e->getMessage());
        } catch (FacebookExceptionsFacebookSDKException $e) {
            Log::error($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle pagination on Facebook client response
     *
     * @param array $response
     * @return void
     */
    private function handlePagination(array $response)
    {
        if (!isset($response['paging']['next'])) {
            return false;
        }

        return [
            'before' => $response['paging']['cursors']['before'],
            'after' => $response['paging']['cursors']['after']
        ];
    }
}