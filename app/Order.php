<?php

namespace App;

use App\Http\Resources\OrderResource;

/**
 * @property string user_id
 * @property int order_id
 * @property float price
 * @property null date_added
 * @property mixed status
 * @property null url
 * @property mixed service
 */
class Order extends BaseModel
{
    protected $collection = 'orders_collection';
    protected $hidden = ['_id'];

    private const ADD_URL = '/add_order/';
    private const STATUS_URL = '/check_status/${x}/';

    private const NEW_STATUS = 0;
    private const PAID_STATUS = 1;
    private const IN_WORK_STATUS = 2;
    private const COMPLETE_STATUS = 3;
    private const CANCELED_STATUS = 9;

    private const STATUS_LIST = [
        self::NEW_STATUS => 'Новый',
        self::PAID_STATUS => 'Оплачен',
        self::IN_WORK_STATUS => 'В работе',
        self::COMPLETE_STATUS => 'Выполнен',
        self::CANCELED_STATUS => 'Отменен',
    ];

    public function getStatus()
    {
        $url = str_replace('${x}', $this->order_id, self::STATUS_URL);
        $response = self::curlPost($url);

        if ($response->type === self::STATUS_SUCCESS) {

            $this->service = Service::where('id', $response->data->service_id)->first()->name ?? $response->data->service_id;
            $this->date_added =  $response->data->date_added ?? null;
            $this->status =  self::STATUS_LIST[$response->data->status] ?? $response->data->status;
            $this->url =  $response->data->url ?? null;

            if (!$this->save()) {
                return ['message' => 'Заказ не был сохранён!', 'code' => 500, 'response' => $response];
            }

            return true;
        }
        return ['message' => $response->desc, 'code' => 500];
    }

    public static function createOrder($params)
    {
        $serviceId = Service::where('name', $params['service_id'])->select(['id'])->get()->toArray();

        if(\count($serviceId) > 1){
            return ['message' => 'Найдено больше чем одна запись по данному имени!', 'service' => implode(', ', array_column($serviceId, 'id'))];
        }

        $params['service_id'] = $serviceId[0]['id'];

        $userId = $params['user_id'];
        unset($params['user_id']);

        $response = self::curlPost(self::ADD_URL, $params);

        if ($response->type === self::STATUS_SUCCESS) {
            $order = new self;
            $order->user_id = $userId;
            foreach ($response->data as $key => $item) {
                $order->$key = $item;

            }
            if (!$order->save()) {
                return ['message' => 'Заказ не был сохранён!', 'code' => 500, 'response' => $response];
            }

            return new OrderResource($order);
        }

        return ['message' => $response->desc, 'code' => 500];
    }
}
