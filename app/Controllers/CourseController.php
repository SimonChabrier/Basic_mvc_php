<?php

namespace App\Controllers;
use App\Models\Course;


class CourseController extends CoreController
{   
    /**
     * List all courses
     *
     * @return void
     */
    public function showCourses()
    {   
        $courses = Course::findAll();
        
        //create a Json file with all courses;       
        $coursesArray = Course::findAllCoursesAndReturnASSOC();
        $json = json_encode($coursesArray);
        $file = 'courses.json';

        //public path
        //$path = __DIR__ . '/../../public/assets/json/';

        //app path
        $path = __DIR__ . './../json/';
        file_put_contents($path . $file, $json);

        //recherche une correspondance de valeur dans un tableau associatif
        // ici dans title la valeur "Quos eos ipsa quo amet nihil do" et on tourve le cours 
        // qui a ce titre....
        $array = json_decode($json, true);
        $search_value = "necessitatibus";

        $result = array_filter($array, function ($search_index) use ($search_value) {
        
        // chercher la valeur strictement exacte    
        //return ($search_index['title'] == $search_value);

            //chercher une valeur jusqu'à 5 signes sucessifs correspondants dans la chaine de caractère
            if (strpos($search_index['title'], $search_value, 5) !== false) {
                return true;
            } else {
                return false;
            }
        });
        
        dump($result);
        
        $this->show('home', ['courses' => $courses]);
    }

    /**
     * Sort a course by the id
     * of url last segment value
     */
    public function showCourse()
    {   
        $id = $this->findUrlLastSegment();
        $course = Course::find($id);
        $this->show('cours', ['course' => $course]);
    }

    /**
     * Display the form to create a course
     *
     * @return void
     */
    public function showForm() 
    {   
        $id = $this->findUrlLastSegment();
        $course = Course::find($id);

        $courses = Course::findAll();
        
        $this->show('form', ['courses' => $courses, 'course' => $course]);
    }

    /**
     * Process the form to create new Course
     * @return void
     */
    public function courseCreate()
    {   
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
        $duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
        $short_description = filter_input(INPUT_POST, 'short_description', FILTER_SANITIZE_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture');
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        $is_published = filter_input(INPUT_POST, 'is_published', FILTER_VALIDATE_BOOLEAN);

        $course = new Course();

        $course->setTitle($_POST['title'])
        ->setPrice($_POST['price'])
        ->setDuration($_POST['duration'])
        ->setShort_description($_POST['short_description'])
        ->setDescription($_POST['description'])
        ->setIs_published($_POST['published']);

        //TODO ajouter les champs manquant ici et dans le model en propriétés et les décommenter dans le formulaire

        if($_FILES['picture'])
        {
            $this->processUploadPicture($_FILES['picture'], $course);
        }
     
        if ($course->insert()) 
        {   
            //TODO ajouter un message de succès
            //TODO rediriger vers le nouveau post créé
            $this->redirect('main-home');
        } 

        else 
        {
            echo 'Il y a une erreur';
        }
        
        $this->show('form', []);
    }
    
    /**
     * @param array $_FILES['picture']
     * @param Course $course
     * @return void
     */
    public function processUploadPicture(array $picture, object $object)
    {
        $picture = $_FILES['picture']['tmp_name'];
        $name = $_FILES['picture']['name'];
        $name  = uniqid() . '.jpeg';
        
        if($_FILES['picture']['size'] > 500000){
            throw new \Exception('Le fichier est trop gros');
        };
        
        if($_FILES['picture']['error'] > 0){
            throw new \Exception('Erreur lors du transfert de l\'image');
        };

        $object->setPicture($name);
        // move file to public assets/images folder
        move_uploaded_file($picture, __DIR__ . '/../../public/assets/images/' . $name);
        //then set the user rigths on this file
        chmod(__DIR__ . '/../../public/assets/images/'.$name, 0777);
    }

    /**
     * Process the form to update a course
     * @return void
     */
    public function courseUpdate()
    {   
        $redirect = NULL;
        $errors = [];

        if (isset($_POST["publishCourseBtn"]) && isset($_POST['lastLocation'])) {
            
            $redirect = $_POST['lastLocation'];

            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
            $duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
            $short_description = filter_input(INPUT_POST, 'short_description', FILTER_SANITIZE_SPECIAL_CHARS);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $is_published = filter_input(INPUT_POST, 'published', FILTER_VALIDATE_BOOLEAN);

            $id = $this->findUrlLastSegment();
            
            $course = Course::find($id);

            $course->setTitle($title)
            ->setPrice($price)
            ->setDuration($duration)
            ->setShort_description($short_description)
            ->setPicture($picture)
            ->setDescription($description)
            ->setIs_published($is_published);

                if ($course->update($id)) {
                    //TODO : ajouter un message si modification n'a été apportée
                    $this->redirectLastPageVisited($redirect);
                } elseif ($course === $course) {
                    //TODO : ajouter un message si aucune modification n'a été apportée
                    $this->redirectLastPageVisited($redirect);
                } else {
                    strlen($short_description) > 255 ? $errors[] = 'La description courte ne doit pas dépasser 255 caractères' : 'erreur inconnue';
                    $this->show('form', ['errors' => $errors, 'course' => $course]);
                }
            }
        
        $id = $this->findUrlLastSegment();
        $course = Course::find($id);
        $courses = Course::findAll();

        $this->show('form', ['courses' => $courses, 'course' => $course]);

    }

    /**
     * Delete a course
     * @return void
     */
    public function courseDelete()
    {   
        $id = $this->findUrlLastSegment();
        $course = Course::find($id);

        if ($course->delete($id)) {
            unlink(__DIR__ . '/../../public/assets/images/' . $course->getPicture());

            $this->redirect('main-home');
        } else {
            throw new \Exception('Erreur lors de la suppression');
        } 
    }

    
}