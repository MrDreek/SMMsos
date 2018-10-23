<?php

namespace App;

use Ixudra\Curl\Facades\Curl;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * App\BaseModel
 *
 * @property mixed updated_at
 * @property-read mixed $id
 * @mixin \Eloquent
 */
class BaseModel extends Eloquent
{
    public const TWELVE_HOURS_IN_SECONDS = 43200;
    public const URL = 'https://dripfeedpanel.com/api/v2';

    public $timestamps = false;

    protected static function curlPost($body)
    {
        $response = Curl::to(self::URL);

        // если нужен прокси
        if (config('app.proxy')) {
            $response = $response->withProxy(config('app.proxy_url'), config('app.proxy_port'), config('app.proxy_type'), config('app.proxy_username'), config('app.proxy_password'));
        }

        return json_decode($response
            ->withData($body)
            ->post());
    }

    /**
     * Если текущее время минус время прошлой записи меньше 12 часов, то запись валидная
     * @return bool
     */
    public function checkValid(): bool
    {
        return time() - $this->updated_at < self::TWELVE_HOURS_IN_SECONDS;
    }
}
