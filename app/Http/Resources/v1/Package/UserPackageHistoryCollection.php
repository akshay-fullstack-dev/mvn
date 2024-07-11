<?php

namespace App\Http\Resources\v1\Package;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserPackageHistoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $collects = UserPackageHistoryResource::class;
    public function toArray($request)
    {
        return [
            'items' => $this->collection,
            'total_items' => $this->total(),
            'current_item_count' => $this->count(),
            'items_per_page' => $this->perPage(),
            'page_index' => $this->currentPage(),
            'total_pages' => $this->lastPage()
        ];
    }
}
