<?php

namespace App;

use Ixudra\Curl\Facades\Curl;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * App\BaseModel
 *
 * @property mixed updated_at
 * @property mixed $id
 * @mixin \Eloquent
 */
class BaseModel extends Eloquent
{
    protected const TWELVE_HOURS_IN_SECONDS = 43200;

    protected const BASE_URL = 'https://smmpanel.ru/api';

    protected const STATUS_SUCCESS = 'success';

    public $timestamps = false;

    protected static function curlPost($url, $addBody = null)
    {
        $key = config('app.api_key');
        $body = ['api_key' => $key];

        $response = Curl::to(self::BASE_URL . $url);

        // если нужен прокси
        if (config('app.proxy')) {
            $response = $response->withProxy(config('app.proxy_url'), config('app.proxy_port'), config('app.proxy_type'), config('app.proxy_username'), config('app.proxy_password'));
        }

        if ($addBody !== null) {
            $body = array_merge($body, $addBody);
        }

        return $response
            ->withData($body)
            ->asJson()
            ->post();
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
