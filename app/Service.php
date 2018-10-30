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

    public static function filteredCategory($request)
    {
        $category_id = Category::select(['id'])->where('full_name', $request->platform . ' -> ' . $request->category)->firstOrFail()->id;
        return self::select(['name'])->where('category_id', $category_id)->orderBy('name')->get();
    }
}
