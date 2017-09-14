<?php
namespace controllers;
use models\User;
use components\Session;
use components\Controller;

class UserController extends Controller
{
    public function actionIndex()
    {
        if( User::helloUser() ){

            $data = Session::getInstance();
            $arrCookie = explode('|', $data->cookie);
            self::$title = 'Кабинет';

            echo $this->render('cabinet', [
                    'title' => self::$title,
                    'arrayCookie' => $arrCookie,
            ]);

        }else{
            header("Location: user/check");
        }
    }

    public function actionAdd()
    {
        if( !User::helloUser() ) {

            self::$title = 'Регистрация';
            echo $this->render('registration', [
                    'title' => self::$title,
            ]);

        }else{
            header("Location: /user");
        }
    }

    public function actionCheck()
    {
        if( !User::helloUser() ) {

            self::$title = 'Авторизация';
            echo $this->render('authorization', [
                    'title' => self::$title,
            ]);

        }else{
            header("Location: /user");
        }
    }

    public function actionLogout()
    {
        if( User::helloUser() ){

            $data = Session::getInstance();
            $data->destroy();
        }

        header("Location: /user/check");
    }

    public function actionRegistration()
    {
        if( User::helloUser()) {

            header("Location: /user");

        }

        if(isset($_POST['username']) AND isset($_POST['password'])){

           $username = strip_tags(trim($_POST['username']));
           $password = strip_tags(trim($_POST['password']));

           $user = new User($username, $password);

           if( $user->addUser() ){
               self::$title = 'Успешная регистрация';
               echo $this->render('success_registration', [
                   'title' => self::$title,
               ]);
           }
       }
    }

    public function actionAuthorization()
    {
        if ( User::helloUser() ){

            header("Location: /user");

        }

        if(isset($_POST['username']) AND isset($_POST['password'])){

            $username = strip_tags(trim($_POST['username']));
            $password = strip_tags(trim($_POST['password']));

            $user = new User($username, $password);

            if( $user->checkUser() ){

                header("Location: /");

            }else{

                self::$title = 'Авторизация';
                $text = 'Неверный логин и/или пароль';

                echo $this->render('notification', [
                    'title' => self::$title,
                    'text' => $text,
                ]);

            }
        }
    }
}