<?php
 
namespace App\Models;

use App\Repository\UserRepository;
use DateTime;

class User extends UserRepository
{

   /**
     * @var int
     */
    protected int $id;

    /**
     * @var string
     */
    protected string $username;

    /**
     * @var string
     * notnull
     */
    protected string $email;

    /**
     * @var string
     * notnull
     */
    protected string $password;

    /**
     * @var bool
     * nullable
     */
    protected bool $status;

    /**
     * @var[string]
    */
    protected $role;

    /**
     * @var DateTime
     * this is automatized by the database with the current date
     */
    protected $updated_at;

    /**
     * @var DateTime
     * this is automatized by the database with the current date
     */
    protected $created_at;


    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set nullable because it can be null
     *
     * @param  DateTime  $updated_at  nullable because it can be null
     *
     * @return  self
     */ 
    public function setUpdated_at(DateTime $updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at(DateTime $created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

}