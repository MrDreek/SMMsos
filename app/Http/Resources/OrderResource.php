<?php

namespace App\Http\Resources;

use App\Service;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed order_id
 * @property mixed price
 * @property mixed service
 * @property mixed status
 * @property mixed url
 * @property mixed date_added
 * @property mixed request_params
 * @property mixed count
 * @property mixed _id
 */
class OrderResource extends JsonResource
{
    public static $wrap = '';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->order_id ?? $this->_id,
            'date_added' => \Carbon\Carbon::parse($this->date_added)->format('d.m.Y H:i'),
            'service' => Service::where('id', $this->request_params['service_id'])->first()->name ?? null,
            'status' => $this->status,
            'count' => $this->request_params['count'],
            'url' => $this->request_params['url'],
            'code' => 200
        ];
    }
}
