<?php

namespace App;


/**
 * @property mixed service
 */
class Service extends BaseModel
{
    protected $collection = 'services_collection';
    protected $hidden = ['_id', 'category'];

    public static function saveServicesFromApi()
    {
        $key = config('app.api_key');
        $body = [
            'key' => $key,
            'action' => 'services'
        ];

        self::truncate();
        Category::truncate();

        $response = self::curlPost($body);

        $result = array_unique(array_column($response, 'category'));
        foreach ($result as $item) {
            $category = new Category;
            $category->category = $item;
            $category->save();
        }


        foreach ($response as $item) {
            $service = new self;
            $service->service = $item->service;
            $service->name = $item->name;
            $service->type = $item->type;
            $service->rate = $item->rate;
            $service->min = $item->min;
            $service->max = $item->max;
            $service->category = $item->category;
            $service->save();
        }
        return [
            'categories' => 'Было сохранено ' . Category::count() . ' категорий из ' . \count($result),
            'services' => 'Было сохранено ' . self::count() . ' сервисов из ' . \count($response)
        ];
    }
}
