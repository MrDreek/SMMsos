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
 * @property array|mixed request_params
 * @property mixed created_at
 */
class Order extends BaseModel
{
    protected $collection = 'orders_collection';
//    protected $hidden = ['_id', 'request_params'];

    private const ADD_URL = '/add_order/';
    private const STATUS_URL = '/check_status/${x}/';

    public $timestamps = true;

    private const NEW_STATUS = 0;
    private const PAID_STATUS = 1;
    private const IN_WORK_STATUS = 2;
    private const COMPLETE_STATUS = 3;
    private const REQUIRED_PAID = 4;
    private const CANCELED_STATUS = 9;

    private const STATUS_LIST = [
        self::NEW_STATUS => 'Новый',
        self::REQUIRED_PAID => 'Ждёт оплаты',
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
            $this->date_added = $response->data->date_added ?? null;
            $this->status = self::STATUS_LIST[$response->data->status] ?? $response->data->status;
            $this->url = $response->data->url ?? null;

            if (!$this->save()) {
                return ['message' => 'Заказ не был сохранён!', 'code' => 500, 'response' => $response];
            }

            return true;
        }
        return ['message' => $response->desc, 'code' => 500];
    }

    public function checkPaid()
    {
        if (isset($this->request_params['service_id'])) {
            $service = Service::where('id', $this->request_params['service_id'])->firstOrFail();
        }


        return [
            'price' => $service->price ?? $this->price ?? null,
            'wait_pay' => $this->status === self::STATUS_LIST[self::REQUIRED_PAID],
            'created_date' => \Carbon\Carbon::parse($this->date_added, 'Europe/Moscow')->format('d.m.Y H:i') ?? \Carbon\Carbon::parse($this->created_at, 'Europe/Moscow')->format('d.m.Y H:i') ?? null,
            'count' => $this->count ?? $this->request_params['count'] ?? null,
            'service' => $service->name ?? $this->service ?? null,
        ];
    }

    public static function beforeOrderCheck($params)
    {
        $service = Service::where('id', $params['service_id'])->firstOrFail();

        if ($service->min === null || $service->min <= (int)$params['count']) {
            $order = new self;
            $order->user_id = $params['user_id'];
            $order->status = self::STATUS_LIST[self::REQUIRED_PAID];
            $order->request_params = [
                'service_id' => $params['service_id'],
                'url' => $params['url'],
                'count' => $params['count'],
                'options' => $params['options'] ?? null,
            ];
            $order->save();

            return ['message' => 'Заказ создан, Статус: Ждёт Оплаты', 'order_id' => $order->_id];
        }

        return ['message' => 'Для создания заказа требуется указать количество не менее ' . $service->min, 'code' => 400];
    }

    public static function createOrder($params)
    {
        $order = self::where('_id', $params['id'])->firstOrFail();
        $response = self::curlPost(self::ADD_URL, $order->request_params);

        if ($response->type === self::STATUS_SUCCESS) {
            foreach ($response->data as $key => $item) {
                $order->$key = $item;
            }
            $order->status = self::STATUS_LIST[self::PAID_STATUS];
            if (!$order->save()) {
                return ['message' => 'Заказ не был сохранён!', 'code' => 500, 'response' => $response];
            }

            return new OrderResource($order);
        }

        return ['message' => $response->desc, 'code' => 500];
    }

    public static function prepareOrder($params)
    {
        $platform_id = Platform::where('name', $params['platform'])->select(['_id'])->firstOrFail()->_id;
        $category_id = Category::where('platform_id', $platform_id)
            ->where('name', $params['category'])
            ->select(['_id'])
            ->firstOrFail()
            ->_id;

        $service = Service::where('category_id', $category_id)
            ->where('name', $params['service'])
            ->firstOrFail();

        return [
            'service_id' => $service->id,
            'price' => $service->price,
            'min' => $service->min,
        ];
    }
}
