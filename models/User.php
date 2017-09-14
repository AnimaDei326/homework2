<?php

namespace models;
use components\Session;
use Exception;
use components\App;


class User
{
    public $username;
    public $password;
    public $session_id = null;
    public static $pdo = null;

    function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        self::$pdo = App::$app->db->getConnect();
    }

    public function addUser()
    {
        UserRole::setRole();
        try {
            $stmt = self::$pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bindParam(1, $this->username);
            $stmt->bindParam(2, $this->password);
            $stmt->execute();


            $stmt = self::$pdo->prepare("INSERT INTO user_role (id_user, id_role) VALUES (?, ?)");
            $stmt->bindParam(1, self::$pdo->lastInsertId());
            $stmt->bindParam(2, UserRole::$user); //все новые - по умолчанию обычные пользователи
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public static function setRole($id_user, $id_role)
    {
        try{
            $stmt = self::$pdo->prepare("UPDATE user_role SET id_role = ? WHERE id_user = ? LIMIT 1");
            $stmt->bindParam(1, $id_role);
            $stmt->bindParam(2, $id_user);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }

    }

    public function checkUser(){

        try {

            $stmt = self::$pdo->prepare("SELECT id FROM users WHERE username = ? AND password = ? LIMIT 1");
            $stmt->bindParam(1, $this->username);
            $stmt->bindParam(2, $this->password);
            $stmt->execute();

            $id = $stmt->fetchColumn();

            if($id){

                $data = Session::getInstance();
                $data->id = $id;
                $this->session_id = session_id();

                try {

                    $stmt = self::$pdo->prepare("UPDATE users SET session_id = ? WHERE id = ? LIMIT 1");
                    $stmt->bindParam(1, $this->session_id);
                    $stmt->bindParam(2, $id);
                    $stmt->execute();

                } catch (Exception $e) {

                    die ('ERROR: ' . $e->getMessage());

                }

                try {
                    $stmt = self::$pdo->prepare("SELECT id_role FROM user_role WHERE id_user = ? LIMIT 1");
                    $stmt->bindParam(1, $id);
                    $stmt->execute();

                    return true;

                } catch (Exception $e) {

                    die ('ERROR: ' . $e->getMessage());
                }

            }else {

                return false;

            }

        } catch (Exception $e) {

            die ('ERROR: ' . $e->getMessage());

        }
    }

    public static function helloUser(){

        self::$pdo = App::$app->db->getConnect();

        $data = Session::getInstance();
        $id = 0;

        if($data->id){
            $id = $data->id;
        }
        try {

            $stmt = self::$pdo->prepare("SELECT id FROM users WHERE id = ? AND session_id = ? LIMIT 1");
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, session_id());
            $stmt->execute();
            $status = $stmt->fetchColumn();

            if($status){

                return $status;

            }else{

                return false;

            }

        } catch (Exception $e) {

            die ('ERROR: ' . $e->getMessage());

        }
    }

    public static function isManager()
    {
        if( self::helloUser() ){

            $data = Session::getInstance();
            $id = 0;

            if($data->id){
                $id = $data->id;
            }

            try {
                $stmt = self::$pdo->prepare("SELECT id_role FROM user_role WHERE id_user = ? LIMIT 1");
                $stmt->bindParam(1, $id);
                $stmt->execute();
                $id_role = $stmt->fetchColumn();

                if( $id_role == 2 ){

                    return true;

                }else{

                    return false;

                }

            } catch (Exception $e) {

                die ('ERROR: ' . $e->getMessage());
            }

        }
    }
    public static function isAdmin()
    {
        if( self::helloUser() ){

            $data = Session::getInstance();
            $id = 0;

            if($data->id){
                $id = $data->id;
            }

            try {
                $stmt = self::$pdo->prepare("SELECT id_role FROM user_role WHERE id_user = ? LIMIT 1");
                $stmt->bindParam(1, $id);
                $stmt->execute();
                $id_role = $stmt->fetchColumn();

                if( $id_role == 1 ){

                    return true;

                }else{

                    return false;

                }

            } catch (Exception $e) {

                die ('ERROR: ' . $e->getMessage());
            }

        }
    }
}