<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Utils\SearchUtils;
use App\Utils\DateUtils;
use App\Utils\UrlValue;
use App\Utils\Redirect;
use App\Utils\Upload;
use PDO;

class CourseController extends CoreController
{   
    const ROOT = './assets/images/';

    /**
     * List all courses
     * Home page
     * @return mixed
     */
    public function showCourses()
    {   

        $courses_array = Course::dynamicFindAll('course', null, 'fetchAll', PDO::FETCH_ASSOC);
        foreach($courses_array as $course_array)
        {     
            $is_published = $course_array['is_published'];
            if ($is_published == 1){
                $result[] = $course_array;
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
            'courses' => $courses ?? null,
            'search_results' => $search_results ?? null,
            'users' => $users ?? null,
            'last_course' => $last_course ?? null,
            'user_publication' => $user_publication ?? null,
        ]);
    }

    /**
     * Sort a course by the id
     * of url last segment value
     * @return Course
     */
    public function showCourse()
    {   
        $id = UrlValue::findUrlLastSegment();
        $course = Course::find($id);

        //get teacher_id property value from database on this object $course
        $id = get_object_vars($course)['teacher_id'];
        //find course using the int value of $id
        $teacher = Course::findCourseTeacherName($id);
        //if $teacher = false, set $teacher_name to null else get teacher name value from database on this object $teacher
        $teacher == null ? $teacher_name = null : $teacher_name = get_object_vars($teacher)['name'];

        //get program items from json
        $items_string = $course->getProgram_Items();
        //convert json to associative array
        $items_array = json_decode($items_string); 

        $date = DateUtils::compareDate($course->getCreated_at());

        $this->show('cours', compact('course', 'items_array', 'date', 'teacher_name'));
    }

    /**
     * Process the form to create new Course
     * Method GET : show the form
     * Method POST : process the form
     * @return response
     */
    public function courseCreate()
    {   
        $teachers = Teacher::dynamicFindAll('teacher', Teacher::class, 'fetchAll', PDO::FETCH_CLASS);
        // $id = UrlValue::findUrlLastSegment();
        // $course = Course::find($id);
        // dump($course);

        if (isset($_POST["publishCourseBtn"])) {
            //process post data
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
            $duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
            $short_description = filter_input(INPUT_POST, 'short_description', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $is_published = filter_input(INPUT_POST, 'published', FILTER_VALIDATE_BOOLEAN);
            $program_items = $_POST['program_items'];
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);

            //start to create a new course
            $course = new Course();
            $course->setTitle($title)
            ->setPrice($price)
            ->setDuration($duration)
            ->setShort_description($short_description)
            ->setDescription($description)
            ->setIs_published($is_published)
            ->setDate($date = DateUtils::formatDateInFrench($date));

            //process program items and clean value with htmlspecialchars
            $data = htmlspecialchars($program_items);

            foreach (preg_split('/\n|\r\n?/', $data) as $line) {
                $array[] = $line;
            };

            $array = json_encode($array);

            //set program items with processed data
            $course->setProgram_items($array);

            //process image
            if ($_FILES['picture']) {
                Upload::processUploadPicture($_FILES['picture'], $course) == null ? null : $errors = Upload::processUploadPicture($_FILES['picture'], $course);

                if (!empty($errors)) {
                    $this->show('form', [
                        'errors' => $errors,
                        'teachers' => $teachers,
                    ]);
                    //ajouter return pour ne pas executer le reste du code et ne pas ajouter le cours dans la base de données
                    //tant qu'il y a des erreurs dans le formulaire.
                    return;
                }
            }

            if ($course->insert()) {
                //TODO ajouter un message de succès
                //TODO rediriger vers le nouveau post créé
                Redirect::redirect('main-home');
            } else {
                $this->show('form', compact('errors'));
                echo 'Il y a une erreur';
            }
        }
        //display the form
        $this->show('form',['teachers' => $teachers]);
    }
    
    /**
     * Process the form to update a course
     * Method GET : show the form
     * Method POST : process the form
     * @return response
     */
    public function courseUpdate()
    {   
        $redirect = NULL;
        $errors = [];
        //get the course to update
        $id = UrlValue::findUrlLastSegment();
        $course = Course::find($id);
        //set teacher choice list
        $teachers = Teacher::dynamicFindAll('teacher', Teacher::class, 'fetchAll', PDO::FETCH_CLASS);
        
        //processing form
        if (isset($_POST["publishCourseBtn"]) && isset($_POST['lastLocation'])) {
            
            $redirect = $_POST['lastLocation'];
            
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
            $duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
            $short_description = filter_input(INPUT_POST, 'short_description', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $is_published = filter_input(INPUT_POST, 'published', FILTER_VALIDATE_BOOLEAN);
            $program_items = $_POST['program_items'];
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);

            //get the course by id
            $id = UrlValue::findUrlLastSegment();
            $course = Course::find($id);

            //set the new course values
            $course->setTitle($title)
            ->setPrice($price )
            ->setDuration($duration)
            ->setShort_description($short_description)
            ->setDescription($description)
            ->setIs_published($is_published)
            ->setDate($date = DateUtils::formatDateInFrench($date));

            //process program items and clean value with htmlspecialchars
            $data = htmlspecialchars($program_items);

            foreach (preg_split('/\n|\r\n?/', $data) as $line) {
                $array[] = $line; 
            };

            $array = json_encode($array);

            //set program items with processed data
            $course->setProgram_items($array);

            //process image
            if($_FILES['picture']){   
            
                Upload::processUploadPicture($_FILES['picture'], $course) == null ? null : $errors = Upload::processUploadPicture($_FILES['picture'], $course);
                
                if (!empty($errors)) {   
                    $this->show('form', [
                        'errors' => $errors,
                        'course' => $course,
                        'teachers' => $teachers
                    ]);
                    //ajouter return pour ne pas executer le reste du code et ne pas ajouter le cours dans la base de données
                    //tant qu'il y a des erreurs dans le formulaire.
                    return; 
                }
            }

            if ($course->update($id)) {
                //TODO : ajouter un message si modification n'a été apportée
                Redirect::redirectLastPageVisited($redirect);
            } 

            if ($course === $course) {
                //TODO : ajouter un message si aucune modification n'a été apportée
                Redirect::redirectLastPageVisited($redirect);
            }    
        }

         //display the form
         $this->show('form', compact('course','teachers'));
    }

    /**
     * Delete a course
     * @return response
     */
    public function courseDelete()
    {   
        $id = UrlValue::findUrlLastSegment();
        $course = Course::find($id);

        if ($course->delete($id)) {
            //unlink picture only if != default.jpg
            $course->getPicture() != 'default.jpg' ?  unlink(self::ROOT . $course->getPicture()) : false;
            Redirect::redirect('main-home');

        } else {
            throw new \Exception('Erreur lors de la suppression');
        } 
    }

    
}