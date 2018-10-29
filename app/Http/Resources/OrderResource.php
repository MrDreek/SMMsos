<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed order_id
 * @property mixed price
 * @property mixed service
 * @property mixed status
 * @property mixed url
 * @property mixed date_added
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
        $response = [
            'order_id' => $this->order_id,
            'price' => $this->price,
            'code' => 200
        ];

        if (isset($this->status)) {
            $response = array_merge($response, [
                'date_added' => \Carbon\Carbon::parse($this->date_added)->format('d.m.Y H:i'),
                'service' => $this->service,
                'status' => $this->status,
                'url' => $this->url,
            ]);
        }

        return $response;
    }
}
