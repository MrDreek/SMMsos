<?php

use App\Category;
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
        $path = storage_path() . '/app/smm_services.json';
        $json = json_decode(file_get_contents($path));

        foreach ($json->data as $key => $item) {
            $category = Category::where('name', trim($item[4]))->first() ?? new Category;
            $category->name = $item[4];
            $category->save();
            $service = \App\Service::where('url', trim($item[1]))->firstOrFail();
            $service->catogory_id = $category->_id;
            $service->save();
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
