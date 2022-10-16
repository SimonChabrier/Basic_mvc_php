<?php

namespace App\Repository;

use App\Models\User;
use App\Utils\Database;
use PDO;

class UserRepository extends Query
{

    /**
     * find All Users from Database
     * @return array[]
     */
    static function findAllUser()
    {
        $pdo = Database::getPDO();
        
        $sql = 'SELECT * FROM `user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, User::class);
        
        return $results;
    }

    /**
     * find All Users from Database
     * @return array[]
     */
    static function findUserCount()
    {
        $pdo = Database::getPDO();
        
        $sql = 'SELECT COUNT(*) FROM `user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        
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
        FROM user
        WHERE id = :id;
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
        $pdoStatement->execute();
        //$user = $pdoStatement->fetchObject(self::class);
        $user = $pdoStatement->fetchObject(User::class);
        
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
        INSERT INTO `user` (`username`, `email`, `password`, `role`, `status`)
        VALUES (:username, :email, :password, :role, :status);
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':username', $this->username, PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_BOOL);
        
        $pdoStatement->execute();
        
        $insertedRows = $pdoStatement->rowCount();
        
        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    /**
     * find User in Database
     * @return user
     */
    public static function finByUsername(string $username)
    {   
        $pdo = Database::getPDO();
        
        $sql = '
        SELECT *
        FROM user
        WHERE username = :username;
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':username', $username, PDO::PARAM_STR);
        //$pdoStatement->bindValue(':username', $this->username, PDO::PARAM_STR);
        $pdoStatement->execute();
        $user = $pdoStatement->fetchObject(User::class);

        return $user;
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