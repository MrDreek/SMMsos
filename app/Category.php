<?php

namespace App;

class Category extends BaseModel
{
    protected $collection = 'category_collection';
    protected $hidden = ['_id'];

    public static function filteredCategories($platformName)
    {
        $platform = Platform::where('name', $platformName)->select(['_id'])->firstOrFail();
        return self::where('platform_id', $platform->_id)->select(['name'])->orderBy('name')->get();
    }
}
