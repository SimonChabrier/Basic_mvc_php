<?php

namespace App\Repository;

use App\Models\Teacher;
use App\Utils\Database;
use PDO;

class TeacherRepository extends Query
{

    /**
     * find All Users from Database
     * @return array[]
     */
    static function findAllTeacher()
    {
        $pdo = Database::getPDO();
        
        $sql = 'SELECT * FROM `teacher`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Teacher::class);
        
        return $results;
    }
    
    /**
     * find One User from Database
     * @return Object
     */
    static function find($id = null)
    {
        $pdo = Database::getPDO();
        
        $sql = '
        SELECT *
        FROM teacher
        WHERE id = :id;
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
        $pdoStatement->execute();
        //$user = $pdoStatement->fetchObject(self::class);
        $user = $pdoStatement->fetchObject(Teacher::class);
        
        return $user;
    }
    
    /**
     * insert new User in Database
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        
        $sql = '
        INSERT INTO `teacher` (`name`)
        VALUES (:name);
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        
        $pdoStatement->execute();
        
        $insertedRows = $pdoStatement->rowCount();
        
        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        
        return false;
    }
    

    /**
     * update User in Database
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        
        
    }

}