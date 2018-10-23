<?php

namespace App;

/**
 * @property string category
 */
class Category extends BaseModel
{
    protected $collection = 'category_collection';
    protected $hidden = ['_id'];
}
