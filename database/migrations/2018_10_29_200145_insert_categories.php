<?php

use App\Category;
use App\Platform;
use Illuminate\Database\Migrations\Migration;

class InsertCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Category::truncate();
        \App\Platform::truncate();
        \App\Service::saveServicesFromApi();

        $path = storage_path() . '/app/smm_services.json';
        $json = json_decode(file_get_contents($path));

        foreach ($json->data as $key => $item) {
            $explode = explode(' -> ', trim($item[4]));

            $platformName = trim($explode[0]);
            $platform = Platform::where('name', $platformName)->first() ?? new Platform;
            $platform->name = $platformName;
            if (!$platform->save()) {
                echo '$platform не сохранена!';
            }

            $categoryName = trim($explode[1]);

            $category = Category::where('full_name', trim($item[4]))->first() ?? new Category;
            $category->name = $categoryName;
            $category->full_name = trim($item[4]);
            $category->platform_id = $platform->_id;
            if (!$category->save()) {
                echo 'Категорий не сохранена!';
            }
            $serviceName = trim($item[1]);
            $service = \App\Service::where('url', $serviceName)->firstOrFail();
            $service->category_id = $category->_id;
            if (!$service->save()) {
                echo 'Сервис не сохранена!';
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
