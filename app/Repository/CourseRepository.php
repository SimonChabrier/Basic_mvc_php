<?php

namespace App\Repository;

use App\Models\Course;
use App\Utils\Database;
use PDO;

class CourseRepository extends Query
{   

    /**
    * find All Courses from Database
    * @return object[]
    */
    static function findAllPublishedCourses()
    {
        $pdo = Database::getPDO();
        
        $sql = 'SELECT * FROM `course`
        WHERE course.is_published = 1
        ORDER BY course.created_at DESC
        ';

        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Course::class);

        return $results;
    }

    
    /**
    * find All published Courses from Database
    * @return array[]
    */
    static function findAllPublishedCourseForSearch()
    {
        $pdo = Database::getPDO();
        
        $sql = 'SELECT * FROM `course`
        WHERE course.is_published = 1
        ORDER BY course.created_at DESC
        ';

        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }


      /**
    * find All Courses from Database
    * @return object[]
    */
    static function findAllPublishedCourseForNav()
    {
        $pdo = Database::getPDO();
        
        $sql = 'SELECT course.id, course.title 
        FROM `course` 
        WHERE course.is_published = 1
        ORDER BY course.title ASC
        ';

        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Course::class);
        
        
        return $results;
    }
    
    
    /**
    * find One Course from Database
    * @return Object
    */
    static function find($id = null)
    {
        $pdo = Database::getPDO();
        
        $sql = '
        SELECT *
        FROM course
        WHERE id = :id;
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
        $pdoStatement->execute();
        $course = $pdoStatement->fetchObject(Course::class);
        
        return $course;
    }
    
    /**
    * insert new Course in Database
    * @return bool
    */
    public function insert()
    {
        $pdo = Database::getPDO();
        
        $sql = '
        INSERT INTO `course` (`title`, `price`, `duration`, `picture`, `short_description`, `description`, `is_published`, `user_id`)
        VALUES (:title, :price, :duration, :picture, :short_description , :description , :is_published, :user_id);
        ';
        
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':title', $this->title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':price', $this->price, PDO::PARAM_INT);
        $pdoStatement->bindValue(':duration', $this->duration, PDO::PARAM_INT);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $pdoStatement->bindValue(':short_description', $this->short_description, PDO::PARAM_STR);
        $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
        $pdoStatement->bindValue(':is_published', $this->is_published, PDO::PARAM_BOOL);
        $pdoStatement->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
        $pdoStatement->execute();
        
        $insertedRows = $pdoStatement->rowCount();
        
        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    /**
    * update Course in Database
    * @return bool
    */
    public function update($id)
    {
        $pdo = Database::getPDO();
        $sql = '
            UPDATE `course`
            SET 
            `title` = :title,
            `price` = :price, 
            `duration` = :duration, 
            `short_description` = :short_description, 
            `description` = :description, 
            `is_published` = :is_published
            WHERE `id` = :id;
        ';
      
        $pdoStatement = $pdo->prepare($sql);
        
        $pdoStatement->bindValue(':title', $this->title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':price', $this->price, PDO::PARAM_INT);
        $pdoStatement->bindValue(':duration', $this->duration, PDO::PARAM_INT);
        $pdoStatement->bindValue(':short_description', $this->short_description, PDO::PARAM_STR);
        $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
        $pdoStatement->bindValue(':is_published', $this->is_published, PDO::PARAM_BOOL);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        
        $pdoStatement->execute();
        
        $updatedRows = $pdoStatement->rowCount();
        return ($updatedRows > 0);
    }
    
    /**
    * Delete course in database
    *
    * @return bool
    */
    public function delete($id)
    {
        $pdo = Database::getPDO();
        $sql = '
        DELETE FROM course
        WHERE id = :id
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->execute();
        
        $deletedRows = $pdoStatement->rowCount();
        return ($deletedRows > 0);
    }
    
    
}