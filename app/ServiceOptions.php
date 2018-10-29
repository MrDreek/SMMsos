<?php

namespace App;

/**
 * @property string category
 */
class ServiceOptions extends BaseModel
{
    private const SERVICE_OPTION_URL = '/get_service_options/${x}/';

    public static function loadOptionFromApi($id)
    {
        $url = str_replace('${x}', $id, self::SERVICE_OPTION_URL);
        return self::curlPost($url);
    }
}
