<?php

namespace models;
use Exception;
use components\App;


class Admin extends User
{


    public static function getUsersByIdRole($idRole)
    {

        self::$pdo = App::$app->db->getConnect();

        try {

            $stmt = self::$pdo->prepare(
                "SELECT * FROM users LEFT JOIN user_role ON user_role.id_user = users.id WHERE user_role.id_role = ?");
            $stmt->bindParam(1, $idRole);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;

        } catch (Exception $e) {

            die ('ERROR: ' . $e->getMessage());

        }
    }

}