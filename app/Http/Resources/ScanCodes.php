<?php

namespace App\Http\Resources;

use App\Http\Resources\Users as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

class ScanCodes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => Hashids::encode($this->id),
            'user' => new UserResource($this->user),
            'scancode_uri' => $this->scan_code_uri,
            'facebook_page' => [
                'id' => $this->facebook_page_id,
                'name' => $this->facebook_page_name,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
