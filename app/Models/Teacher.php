<?php

namespace App\Models;

use App\Repository\Query;
use App\Repository\TeacherRepository;

class Teacher extends TeacherRepository

{

/**
 * @var int
 */
protected $id;

/**
 * @var string
 */
protected $name;

/**
 * Get the value of id
 */
public function getId():int
{
    return $this->id;
}

/**
 * Set the value of id
 * @return  self
 */
public function setId($id)
{
    $this->id = $id;

    return $this;
}

/**
 * Get the value of name
 */ 
public function getName()
{
return $this->name;
}

/**
 * Set the value of name
 * @return  self
 */ 
public function setName($name)
{
$this->name = $name;

return $this;
}


}