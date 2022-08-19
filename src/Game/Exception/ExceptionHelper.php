<?php

namespace App\Game\Exception;

use Exception;
use GuzzleHttp\Exception\BadResponseException;

class ExceptionHelper
{
    public static function getExceptionAsArray(Exception $exception): array
    {
        return [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getLine(),
            'line' => $exception->getLine()
        ];
    }

    public static function getGuzzleExceptionAsArray(BadResponseException $exception)
    {
        return array_merge(self::getExceptionAsArray($exception), [
            'responseContent' => $exception->getResponse()->getBody()->getContents(),
            'responseCode' => $exception->getResponse()->getStatusCode(),
            'requestContent' => $exception->getRequest()->getBody()->getContents()
        ]);
    }
}