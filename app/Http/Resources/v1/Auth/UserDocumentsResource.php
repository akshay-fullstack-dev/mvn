<?php

namespace App\Http\Resources\v1\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDocumentsResource extends JsonResource
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
            'id' => $this->id,
            'document_name' => $this->document_name,
            'document_number' => $this->document_number ?? "",
            'front_image' => $this->front_image,
            'back_image' => $this->back_image ?? "",
            'document_type' => $this->document_type,
            'document_status' => $this->document_status,
            'message' => $this->message ?? "",
        ];
    }
}
