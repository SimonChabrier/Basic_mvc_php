<?php

namespace App\Repository;
use App\Utils\Database;
use PDO;

class Query
{

    /**
    * find All from $table
    * @param string $table
    * @param string $class (eg Course::class)
    * @return array[]
    */

    static function dynamicFindAll($table, $class, $fetchMethod, $fetchMode)
    {
        $pdo = Database::getPDO();
        
        $sql = 'SELECT * FROM ' . $table;
        $pdoStatement = $pdo->query($sql);

        if ($class != null){
        $results = $pdoStatement->$fetchMethod($fetchMode, $class);
        } 

        if($class == null) {
            $results = $pdoStatement->$fetchMethod($fetchMode);
        }
        return $results;
    }


    /**
    * find All from $table with limit and order by created_at
    * @param string $table
    * @param string $class (eg Course::class)
    * @return array[]
    */

    static function dynamicFindAllWithLimit($table, $class , $order, $limit)
    {
        $pdo = Database::getPDO(); 
        $sql = 'SELECT * FROM ' . $table . ' ORDER BY created_at ' . $order . ' LIMIT ' . $limit;
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, $class);

        return $results;
    }


}