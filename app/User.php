<?php

namespace App;


class User extends BaseModel
{
    public static function getBalance()
    {
        $key = config('app.api_key');
        $body = [
            'key' => $key,
            'action' => 'balance'
        ];

        return self::curlPost($body);
    }
}
