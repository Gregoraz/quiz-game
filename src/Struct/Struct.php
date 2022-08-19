<?php

namespace App\Struct;

use JsonSerializable;

abstract class Struct
{
    public function decodeText(string $text): string
    {
        return trim(html_entity_decode(utf8_decode($text)));
    }
}