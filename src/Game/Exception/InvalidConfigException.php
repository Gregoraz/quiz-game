<?php

namespace App\Game\Exception;

use Exception;

class InvalidConfigException extends Exception
{
    public function __construct(string $configKey, string $expectedType)
    {
        $message = sprintf(
            'Missing or invalid config value. Key: %s is required as a type: %s',
            $configKey, $expectedType
        );
        parent::__construct($message, 400);
    }
}