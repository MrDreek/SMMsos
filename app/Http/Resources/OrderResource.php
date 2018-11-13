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
        $service = Service::where('id', $this->request_params['service_id'])->first();
        $date_added = $this->date_added ?? $this->created_at ?? null;
        return [
            'order_id' => $this->order_id ?? $this->_id,
            'date_added' => $date_added !== null ? \Carbon\Carbon::parse($date_added, 'Europe/Moscow')->format('d.m.Y H:i') : null,
            'service' => $this->service ??  $service->name  ?? null,
            'status' => $this->status,
            'wait_paid' => $this->status === 'Ждёт оплаты',
            'price' => $this->price ?? $service->price ?? null,
            'count' => $this->request_params['count'],
            'url' => $this->url ?? $this->request_params['url'] ?? null,
            'code' => 200
        ];
    }
}
