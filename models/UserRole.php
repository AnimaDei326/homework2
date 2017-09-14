<?php

namespace models;
use components\App;
use Exception;

//устанавливаем в статические переменные id для статусов заказов,
// чтоб в случае изменений в бд поменять их только в одном месте

class UserRole
{
    public static $user;
    public static $manager;
    public static $admin;

    public static $pdo = null;

    public static function setRole()
    {
        if( self::$pdo == null ) {

            self::$pdo = App::$app->db->getConnect();

            try {
                $stmt = self::$pdo->prepare("SELECT * FROM role");
                $stmt->execute();
                $data = $stmt->fetchAll();
                foreach ($data as $item) {
                    switch ($item['user_role_name']) {
                        case 'admin' :
                            self::$admin = $item['id'];
                            break;
                        case 'manager' :
                            self::$manager = $item['id'];
                            break;
                        case 'user' :
                            self::$user = $item['id'];
                            break;
                    }
                }
            } catch (Exception $e) {
                die ('ERROR: ' . $e->getMessage());
            }
        }
    }
}