<?php

namespace App\Utils;


class SearchUtils
{
    /**
     * Find a value in a json
     * @param array
     * @param string $value
     * @return array
     */
    public static function findInJson($arrayData, $input_value){
    
    //create a Json file with all value of $arrayData;
    $json = json_encode($arrayData);
    $file = 'courses.json';

    //app path
    $path = __DIR__ . './../json/';
    file_put_contents($path . $file, $json);

    //convert the file data in associative array
    $data = json_decode($json, true);

    //search by $input_value on the array $data using callback function
    $search_result = array_filter($data, function ($data_item) use ($input_value) {
        return stripos($data_item['title'], $input_value) !== false ? true : false;
    });
        return $search_result == [] ? 'Pas de résultat !' : $search_result;
    }
}

