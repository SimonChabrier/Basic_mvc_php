<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends CoreController
{
    /**
     * Méthode gérant l'affichage du formulaire d'inscription
     * @return void
     */
    public function register()
    {   
        $this->show('register');
    }

    /**
     * User registration
     * @return void
     */
    public function registration()
    {   

        if (isset($_POST['registerBtn']))
        { 
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        
            $user = New User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $user->setStatus(1);
            $user->setRole("ROLE_USER");

            //persist user in database redirect to home page
            if ($user->insert()) 
            {   
                // put username in session
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['role'] = $user->getRole();
                $this->redirect('main-home');
            } 
            else 
            {
                throw new \Exception("Erreur lors de l'insertion en base de données");
            }
        }
    }

    /**
     * User authenticate
     * @return void
     */
    public function logIn()
    {   
        //TODO retourné les valeurs déjà saisies par l'utilisateur dans le form si erreur
        $redirect = null;
        $errors = [];
   
        //* process POST request
        if (isset($_POST['loginBtn'])) 
        {   
            //get last user location from input hidden
            $redirect = $_POST['lastLocation'];

            //check if username and password are not empty
            if ($_POST['username'] === '')
            {
                $errors[] = "Nom d'utilisateur non renseigné";
                $newToken = $this->initToken();
                $_SESSION['token'] = $newToken;
                
                $this->show('login',['token' => $newToken,'errors' => $errors]);
                exit();
            }

            if ($_POST['password'] === '')
            {
                $errors[] = "Mot de passe non renseigné";
                $newToken = $this->initToken();
                $_SESSION['token'] = $newToken;
                
                $this->show('login',['token' => $newToken,'errors' => $errors]);
                exit();
            }

            //if no errors before enter here to find user in database
            if ($_SESSION['token'] === $_POST['token']) 
            {
                $user = User::finByUsername($_POST['username']);
                // if everything is true authenticate this user and redirect to last page visited
                if ($user &&  password_verify($_POST['password'], $user->getPassword())) 
                {                   
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['role'] = $user->getRole();
                    unset($_SESSION['token']);

                    $this->redirectLastPageVisited($redirect);
                }
                // if password is not correct
                if(!password_verify($_POST['password'], $user->getPassword()))
                {
                    $errors[] = "Mot de passe incorrect";
                    $newToken = $this->initToken();
                    $_SESSION['token'] = $newToken;
                    
                    $this->show('login',['token' => $newToken,'errors' => $errors]);
                    exit();
                }
                // if user does not exist
                if (!$user) 
                {
                    $errors[] = "Utilisateur inconnnu !";
                    $newToken = $this->initToken();
                    $_SESSION['token'] = $newToken;
                    
                    $this->show('login',['token' => $newToken,'errors' => $errors]);
                    exit();
                }
            }
        }

        //* GET login page
        $this->show('login', ['token' => $this->initToken()], ['errors' => $errors]);
    }

    /**
     * User logout
     * @return void
     */
    public function logOut(){
        session_destroy();
        $this->redirect('main-home');
    }
}