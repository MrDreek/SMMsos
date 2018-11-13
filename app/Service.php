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
        Category::truncate();
        Platform::truncate();

        $response = self::curlPost(self::SERVICE_URL);

        if ($response->type === self::STATUS_SUCCESS) {
            foreach ($response->data as $key => $item) {
                $explode = explode(' -> ', trim($item->group_name));

                $platformName = trim($explode[0]);
                $platform = Platform::where('name', $platformName)->first() ?? new Platform;
                $platform->name = $platformName;
                if (!$platform->save()) {
                    echo '$platform не сохранена!';
                }

                $categoryName = trim($explode[1]);

                $category = Category::where('full_name', trim($item->group_name))->first() ?? new Category;
                $category->name = $categoryName;
                $category->full_name = trim($item->group_name);
                $category->platform_id = $platform->_id;
                if (!$category->save()) {
                    echo 'Категорий не сохранена!';
                }

                $serviceName = trim($item->name);
                $service = self::where('url', $serviceName)->first() ?? new self;
                $service->category_id = $category->_id;
                $service->id = $item->id;
                $service->name = $serviceName;
                $service->url = $item->url;
                $service->group_id = $item->group_id;
                $service->group_name = $item->group_name;
                $service->price = $item->price;
                $service->min = $item->min;
                if (!$service->save()) {
                    echo 'Сервис не сохранена!';
                }
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
