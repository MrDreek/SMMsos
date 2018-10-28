<?php

namespace App;


class User extends BaseModel
{
    protected $collection = 'users_collection';
    private const BALANCE_URL = '/balance/';

    public static function getBalance()
    {
        return self::curlPost(self::BALANCE_URL);
    }
}
