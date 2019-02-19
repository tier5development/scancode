<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ScanCode;
use App\Http\Resources\ScanCodes as ScanCodeResource;

class ScanCodesController extends Controller
{
    public function store(Request $request)
    {
        return new ScanCodeResource(ScanCode::create([
            'user_id' => trim($request->input('facebook_user_id')),
            'facebook_page_id' => trim($request->input('facebook_page_id')),
            'facebook_page_name' => trim($request->input('facebook_page_name')),
            'scan_code_uri' => trim($request->input('scancode_uri')),
        ]));
    }
}
