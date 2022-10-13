<?php

namespace App\Controllers;
use App\Models\Course;
use App\Utils\Search;


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

        $input_value = $_GET['searchInputValue'] ?? null;

        if (isset($input_value)) {
            $coursesArray = Course::findAllCoursesAndReturnASSOC();
            $results = Search::findInJson($coursesArray, $input_value);
            //reset $courses with the results of the search
            $courses = 0;
        }
        
        $this->show('home', [
            'courses' => $courses,
            'results' => $results ?? null,
        ]);
    }

    /**
     * Sort a course by the id
     * of url last segment value
     */
    public function showCourse()
    {   
        $id = $this->findUrlLastSegment();
        $course = Course::find($id);

        $date = new \App\Utils\Date();
        $value = $date->compareDate($course->getCreated_at());
        dump($value);
        $this->show('cours', ['course' => $course, 'value' => $value]);
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