<?php

namespace App\Http\Resources\v1\Version;

use Illuminate\Http\Resources\Json\JsonResource;

class VersionResource extends JsonResource
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
            'force_update'=>$this->force_update,
            'message'=>$this->message,
            'version'=>$this->version,
            'code'=>$this->code,
            'platform'=>$this->platform,
        ];
    }
}
