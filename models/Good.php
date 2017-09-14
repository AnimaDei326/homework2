<?php
namespace models;
use components\App;
use Exception;

class Good
{
    public $id;
    public $name;
    public $status;
    public $price;
    public $description;
    public $idCategory;
    public $path;

    public static $pdo = null;

    public function __construct($name, $price, $description, $idCategory)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->idCategory = $idCategory;
        $this->status = true;

        self::$pdo = App::$app->db->getConnect();
    }

    public static function showGood($status)
    {
        self::$pdo = App::$app->db->getConnect();

        try {

            $stmt = self::$pdo->prepare("SELECT * FROM goods WHERE status = ?");
            $stmt->bindParam(1, $status);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function addGood()
    {
        $this->path = 'null.png';

        function generateCode($length) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
            $code = "";
            $clen = strlen($chars) - 1;
            while (strlen($code) < $length)
            {
                $code .= $chars[mt_rand(0,$clen)];
            }
            return $code;
        }
        if($_FILES['userfile']['size'] > 0)
        {
            $uploaddir = 'images';
            $pre = generateCode(20);
            $extension = strtolower(substr(strrchr($_FILES['userfile']['name'], '.'), 1));
            $target = $uploaddir . '/' . $pre . '.' . $extension;
            $this->path = $pre . '.' . $extension;
            move_uploaded_file($_FILES['userfile']['tmp_name'], $target);
        }
        try {
            $stmt = self::$pdo->prepare(
                "INSERT INTO goods (good_name, status, price, description, id_category,  path) 
                          VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $this->name);
            $stmt->bindParam(2, $this->status);
            $stmt->bindParam(3, $this->price);
            $stmt->bindParam(4, $this->description);
            $stmt->bindParam(5, $this->idCategory);
            $stmt->bindParam(6, $this->path);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function renameGood()
    {
        $this->path = 'null.png';

        function generateCode($length) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
            $code = "";
            $clen = strlen($chars) - 1;
            while (strlen($code) < $length)
            {
                $code .= $chars[mt_rand(0,$clen)];
            }
            return $code;
        }
        if($_FILES['userfile']['size'] > 0)
        {
            $uploaddir = 'images';
            $pre = generateCode(20);
            $extension = strtolower(substr(strrchr($_FILES['userfile']['name'], '.'), 1));
            $target = $uploaddir . '/' . $pre . '.' . $extension;
            $this->path = $pre . '.' . $extension;
            move_uploaded_file($_FILES['userfile']['tmp_name'], $target);
        }
        try {
            $stmt = self::$pdo->prepare("UPDATE goods SET good_name = ? , price = ?, description = ?, id_category = ?, path = ? WHERE id = ? LIMIT 1");
            $stmt->bindParam(1, $this->name);
            $stmt->bindParam(2, $this->price);
            $stmt->bindParam(3, $this->description);
            $stmt->bindParam(4, $this->idCategory);
            $stmt->bindParam(5, $this->path);
            $stmt->bindParam(6, $this->id);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function deleteGood()
    {
        try {
            $stmt = self::$pdo->prepare("DELETE FROM goods WHERE id = ? LIMIT 1");
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            return false;
            //die ('ERROR: ' . $e->getMessage());
        }
    }

    public static function getById($id)
    {
        self::$pdo = App::$app->db->getConnect();

        try {

            $stmt = self::$pdo->prepare("SELECT id, good_name, status, description, price, id_category, path FROM goods WHERE id = ? LIMIT 1");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
    public static function getByIdCategory($id)
    {
        self::$pdo = App::$app->db->getConnect();

        try {

            $stmt = self::$pdo->prepare("SELECT id, good_name, status, description, price, id_category, path FROM goods WHERE id_category = ?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}