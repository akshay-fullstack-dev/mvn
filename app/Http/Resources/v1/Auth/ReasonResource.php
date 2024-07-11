<?php

namespace App\Http\Resources\v1\Auth;

use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class ReasonResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reason' => $this->reason ?? "",
            'type' => $this->type
        ];
    }
}
