<?php

namespace App\Utils;


class UrlValue
{
    /**
     * find last url value 
     * use this on methods need to have an id as parameter
     * @return string
     */
    public static function findUrlLastSegment()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', $url);
        $numSegments = count($segments); 
        $id = $segments[$numSegments - 1];

        return $id;
    }
    
}
