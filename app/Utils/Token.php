<?php

namespace App\Utils;

class Token
{
    public static function initToken()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['token'] = $token;
        return $token;
    }
}