<?php

namespace App;


/**
 * @property mixed service
 */
class Service extends BaseModel
{
    protected $collection = 'services_collection';
    protected $hidden = ['_id', 'category'];

    private const SERVICE_URL = '/get_services/';

    public static function saveServicesFromApi()
    {
        self::truncate();
        ServiceOptions::truncate();

        $response = self::curlPost(self::SERVICE_URL);

        if ($response->type === self::STATUS_SUCCESS) {
            foreach ($response->data as $dataItem) {
                $service = new self;
                foreach ($dataItem as $key => $item) {
                    $service->$key = $item;
                }
                $service->save();
            }

            return [
                'message' => 'Было сохранено ' . self::count(),
                'code' => 200
            ];
        }

        return ['message' => $response->desc, 'code' => 404];
    }

    public static function serviceName($category)
    {
        $category_id = Category::select(['id'])->where('name', $category)->first()->id;

        return array_map(function ($item) {
            return $item['name'];
        }, self::select(['id', 'name'])->where('category_id', $category_id)->orderBy('name')->get()->toArray());
    }
}
