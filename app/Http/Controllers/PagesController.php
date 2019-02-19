<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ScanCode;
use App\Traits\Facebook;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class PagesController extends Controller
{
    use Facebook;

    /**
     * Show the application index page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.login', [
            'scancodes' => ScanCode::orderBy('created_at', 'desc')->limit(5)->get(),
        ]);
    }

    /**
     * Show the tier5 page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tier5()
    {
        return view('tier5', [
            'products' => Product::all(),
        ]);
    }

    /**
     * Show the application dashboard page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $this->getAllPages(Auth::user());

        return view('home', [
            'facebookUserId' => Hashids::encode(Auth::user()->facebook_id),
            'facebookPages' => array_map(function ($page) {
                return json_decode(json_encode([
                    'id' => Hashids::encode($page['id']),
                    'name' => $page['page_token'],
                ]));
            }, $this->pages),
        ]);
    }
}
