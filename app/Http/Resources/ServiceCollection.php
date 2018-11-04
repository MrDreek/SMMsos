<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceCollection extends ResourceCollection
{
    public static $wrap = '';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return array_merge(['Назад ⏪&#9194;'],array_map(function ($item){
            return $item['name'];
        }, $this->collection->toArray()));
    }
}
