<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Facebook;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class AccessTokensController extends Controller
{
    use Facebook;

    public function index(Request $request)
    {
        $facebookUserId = trim($request->input('facebook_user_id'));
        $facebookPageId = trim($request->input('facebook_page_id'));

        $facebookUserId = strlen($facebookUserId) ? Hashids::decode($facebookUserId) : [config('services.facebook.default.user_id')];
        $facebookPageId = strlen($facebookPageId) ? Hashids::decode($facebookPageId) : [config('services.facebook.default.page_id')];

        $user = User::whereFacebookId($facebookUserId[0])->first();

        return $this->generatePageAccessToken($user->remember_token, $facebookPageId[0]);
    }
}
