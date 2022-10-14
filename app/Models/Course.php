<?php
 
namespace App\Models;

use App\Repository\CourseRepository;
use DateTime;

class Course extends CourseRepository
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected string $title ='default title';

    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * @var int
     */
    protected int $duration = 0;

    /**
     * @var string
     */
    protected $short_description = 'default short description';

    /**
     * @var text
     */
    protected string $description = 'default description';

    /**
     * @var string
     */
    protected $picture = null;

    /**
      * @var DateTime
      * this is automatized by the database with the current date
      */
    protected $created_at;

    /**
     * @var DateTime
     * nullable because it can be null
     */
    protected $updated_at;

    /**
     * @var bool
     * not null
     */
    protected bool $is_published;

    /**
     * @var string
     * not null
     */
    protected $program_items = [];
 
    /**
     * Get the value of id
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

   /**
    * Get the value of title
    */
   public function getTitle():string
   {
       return $this->title;
   }

   /**
    * Set the value of title
    *
    * @return  self
    */
   public function setTitle($title)
   {
       $this->title = $title;

       return $this;
   }

   /**
    * Get the value of price
    */
   public function getPrice():int
   {
       return $this->price;
   }

   /**
    * Set the value of price
    *
    * @return  self
    */
   public function setPrice(int $price)
   {
       $this->price = $price;

       return $this;
   }

   /**
    * Get the value of duration
    */
   public function getDuration():int
   {
       return $this->duration;
   }

   /**
    * Set the value of duration
    *
    * @return  self
    */
   public function setDuration(int $duration)
   {
       $this->duration = $duration;

       return $this;
   }

   /**
    * Get the value of picture
    */
   public function getPicture():string
   {
       return $this->picture;
   }

   /**
    * Set the value of picture
    *
    * @return  self
    */
   public function setPicture($picture)
   {
       $this->picture = $picture;
       return $this;
   }

       /**
     * Get the value of short_description
     *
     * @return  string
     */
    public function getShort_description():string
    {
        return $this->short_description;
    }
   
    /**
     * Set the value of short_description
     *
     * @param  string  $short_description
     *
     * @return  self
     */
    public function setShort_description(string $short_description)
    {
        $this->short_description = $short_description;

        return $this;
    }

   /**
    * Get the value of description
    */
   public function getDescription()
   {
       return $this->description;
   }
 
   /**
    * Set the value of description
    *
    * @return  self
    */
   public function setDescription($description)
   {
       $this->description = $description;

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
     * Automatized in database Table 
     * @return  self
     */
    public function setCreated_at($created_at)
    {   
        $this->created_at = $created_at;
    }

    /**
     * Get nullable because it can be null
     *
     * @return  DateTime
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
     * Get not null
     *
     * @return  bool
     */ 
    public function getIs_published()
    {
        return $this->is_published;
    }

    /**
     * Set not null
     *
     * @param  bool  $is_published  not null
     *
     * @return  self
     */ 
    public function setIs_published(bool $is_published)
    {
        $this->is_published = $is_published;

        return $this;
    }

    /**
     * Get not null
     *
     * @return  string
     */ 
    public function getProgram_items()
    {   
        return $this->program_items;
    }

    /**
     * Set not null
     *
     * @param  string  $program_items  not null
     *
     * @return  self
     */ 
    public function setProgram_items(string $program_items)
    {
        $this->program_items = $program_items;

        return $this;
    }
}


