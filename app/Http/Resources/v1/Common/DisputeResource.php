<?php

namespace App\Http\Resources\v1\Common;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class DisputeResource extends JsonResource
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
            'booking_id' => $this->booking_id,
            'user_id' => $this->user_id,
            'message' => $this->message,
            'ticket_id' => $this->ticket_id,
            'is_resolved' => $this->is_resolved,
            'responsed_message' => $this->responsed_message ?? "",
            'responsed_at' => $this->responsed_at ?? "",
            'service_name' => $this->booking->service ? $this->booking->service->name : "",
            'booking_date' => Carbon::parse($this->booking->booking_start_time)->format('y-m-d H:i:s'),
            'created_at' => Carbon::parse($this->created_at)->format("y-m-d H:i:s"),
        ];
    }
}
