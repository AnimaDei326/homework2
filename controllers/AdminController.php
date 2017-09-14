<?php

namespace controllers;

use components\Controller;
use models\Admin;
use models\UserRole;

class AdminController extends Controller
{
    public function actionShowUsers()
    {
        if( Admin::isAdmin() ){

            UserRole::setRole();

            $users = Admin::getUsersByIdRole(UserRole::$user);
            self::$title = 'Пользователи';

            echo $this->render('admin_show_users', [
                'title' => self::$title,
                'users' => $users,
            ]);

        }else{
            header("Location: user/check");
        }
    }
    public function actionShowManagers()
    {
        if( Admin::isAdmin() ){

            UserRole::setRole();

            $users = Admin::getUsersByIdRole(UserRole::$manager);
            self::$title = 'Менеджеры';

            echo $this->render('admin_show_managers', [
                'title' => self::$title,
                'users' => $users,
            ]);

        }else{
            header("Location: user/check");
        }
    }
    public function actionNewUser()
    {
        if( Admin::isAdmin() ){

            UserRole::setRole();

            if( isset($_GET['id'] )){

                $idUser = strip_tags(trim($_GET['id']));

                if( Admin::setRole($idUser, UserRole::$user) ){

                self::$title = 'Новый пользователь';
                $text = 'Роль успешно изменена на пользователя';

                echo $this->render('notification', [
                    'title' => self::$title,
                    'text' => $text,
                ]);
                }
            }else{
                header("Location: admin/showUsers");
            }

        }else{
            header("Location: user/check");
        }
    }
    public function actionNewManager()
    {
        if( Admin::isAdmin() ){

            UserRole::setRole();

            if( isset($_GET['id'] )){

                $idUser = strip_tags(trim($_GET['id']));

                if( Admin::setRole($idUser, UserRole::$manager) ){

                    self::$title = 'Новый менеджер';
                    $text = 'Роль успешно изменена на менеджера';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);
                }
            }else{
                header("Location: admin/showUsers");
            }

        }else{
            header("Location: user/check");
        }
    }
    public function actionNewAdmin()
    {
        if( Admin::isAdmin() ){

            UserRole::setRole();

            if( isset($_GET['id'] )){

                $idUser = strip_tags(trim($_GET['id']));

                if( Admin::setRole($idUser, UserRole::$admin) ){

                    self::$title = 'Новый администратор';
                    $text = 'Роль успешно изменена на администратора';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);
                }
            }else{
                header("Location: admin/showUsers");
            }

        }else{
            header("Location: user/check");
        }
    }
}