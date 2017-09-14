<?php
namespace models;
use components\App;
use Exception;

class Catalog
{
    public $id;
    public $name;
    public $status;
    public static $pdo = null;

   public function __construct($name)
   {
       $this->name = strip_tags(trim($name));
       $this->status = true;
       self::$pdo = App::$app->db->getConnect();
   }

    public static function showCatalog($status)
    {
        self::$pdo = App::$app->db->getConnect();

        try {

            $stmt = self::$pdo->prepare("SELECT id, catalog_name FROM catalogs WHERE status = ?");
            $stmt->bindParam(1, $status);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function addCatalog()
    {

        try {
            $stmt = self::$pdo->prepare("INSERT INTO catalogs (catalog_name, status) VALUES (?, ?)");
            $stmt->bindParam(1, $this->name);
            $stmt->bindParam(2, $this->status);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function renameCatalog()
    {

        try {
            $stmt = self::$pdo->prepare("UPDATE catalogs set catalog_name = ? WHERE id = ?");
            $stmt->bindParam(1, $this->name);
            $stmt->bindParam(2, $this->id);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function deleteCatalog()
    {
        try {
            $stmt = self::$pdo->prepare("DELETE FROM catalogs WHERE id = ? LIMIT 1");
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

            $stmt = self::$pdo->prepare("SELECT id, catalog_name, status FROM catalogs WHERE id = ? LIMIT 1");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

}