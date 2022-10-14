<?php

namespace App\Controllers;
use App\Models\Course;
use App\Utils\SearchUtils;
use App\Utils\DateUtils;
use App\Utils\UrlValue;
use App\Utils\Redirect;
use App\Utils\Upload;
use PDO;

class CourseController extends CoreController
{   
    /**
     * List all courses
     * @return void
     */
    public function showCourses()
    {   

        $courses_array = Course::dynamicFindAll('course', null, 'fetchAll', PDO::FETCH_ASSOC);
        foreach($courses_array as $course_array)
        {     
            $is_published = $course_array['is_published'];
            if ($is_published == 1){
                $result[] = $course_array;
                //dump($result);
            }
        }

        $last_course = Course::dynamicFindAllWithLimit('course', Course::class, 'DESC', 1);
        //dump($last_course);

        $user_publication = Course::findUserPublishedCourses();
        //dump($user_publication);

        $courses = Course::findAllPublishedCourses();
        //dump(gettype($courses[0]->getProgram_Items()));
        $input_value = $_GET['searchInputValue'] ?? null;

        if (isset($input_value)) {
            
            $coursesArray = Course::findAllPublishedCourseForSearch();
            $search_results = SearchUtils::findInJson($coursesArray, $input_value);
            //reset $courses if results in search
            $courses = null;
        }

        $this->show('home', [
            'courses' => $courses,
            'search_results' => $search_results ?? null,
            'users' => $users ?? null,
        ]);
    }

    /**
     * Sort a course by the id
     * of url last segment value
     */
    public function showCourse()
    {   
        $id = UrlValue::findUrlLastSegment();
        $course = Course::find($id);
        $date = DateUtils::compareDate($course->getCreated_at());

        $this->show('cours', ['course' => $course, 'date' => $date]);
    }

    /**
     * Display the form to create a course
     *
     * @return void
     */
    public function showForm() 
    {   

        $id = UrlValue::findUrlLastSegment();
        $course = Course::find($id);
        $courses = Course::findAllPublishedCourses();
        
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
        $program_items = filter_input(INPUT_POST, 'program_items', FILTER_SANITIZE_SPECIAL_CHARS);
      
        $course = new Course();

        $course->setTitle($_POST['title'])
        ->setPrice($_POST['price'])
        ->setDuration($_POST['duration'])
        ->setShort_description($_POST['short_description'])
        ->setDescription($_POST['description'])
        ->setIs_published($_POST['published']);


        $data = htmlspecialchars($_POST['program_items']);
        foreach (preg_split('/\n|\r\n?/', $data) as $line) {
            $array[] = $line; 
        };
        $array = json_encode($array);
        $course->setProgram_items($array);
        

        //TODO ajouter les champs manquant ici et dans le model en propriétés et les décommenter dans le formulaire

        if($_FILES['picture'])
        {   
            
            Upload::processUploadPicture($_FILES['picture'], $course);
        }
     
        if ($course->insert()) 
        {   
            //TODO ajouter un message de succès
            //TODO rediriger vers le nouveau post créé
            Redirect::redirect('main-home');
        } 

        else 
        {
            echo 'Il y a une erreur';
        }
        
        $this->show('form', []);
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

            $id = UrlValue::findUrlLastSegment();
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
                    Redirect::redirectLastPageVisited($redirect);
                } elseif ($course === $course) {
                    //TODO : ajouter un message si aucune modification n'a été apportée
                    Redirect::redirectLastPageVisited($redirect);
                } else {
                    strlen($short_description) > 255 ? $errors[] = 'La description courte ne doit pas dépasser 255 caractères' : 'erreur inconnue';
                    $this->show('form', ['errors' => $errors, 'course' => $course]);
                }
            }
        
        $id = UrlValue::findUrlLastSegment();
        $course = Course::find($id);
        $courses = Course::findAllPublishedCourses();

        $this->show('form', ['courses' => $courses, 'course' => $course]);

    }

    /**
     * Delete a course
     * @return void
     */
    public function courseDelete()
    {   
        $id = UrlValue::findUrlLastSegment();
        $course = Course::find($id);

        if ($course->delete($id)) {
            unlink(__DIR__ . '/../../public/assets/images/' . $course->getPicture());

            Redirect::redirect('main-home');

        } else {
            throw new \Exception('Erreur lors de la suppression');
        } 
    }

    
}