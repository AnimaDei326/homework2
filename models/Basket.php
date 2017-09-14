<?php
namespace models;
use components\App;
use Exception;

class Basket
{
    public $idBasket;
    public $idUser;
    public $idGood;
    public $idOrder;
    public $isInOrder;
    public static $pdo = null;

    public function __construct($idUser, $idGood)
    {
        $this->idUser = $idUser;
        $this->idGood = $idGood;
        $this->isInOrder = 0;
        self::$pdo = App::$app->db->getConnect();
    }

    public static function showBasket($idUser, $isInOrder)
    {
        self::$pdo = App::$app->db->getConnect();
        try {

            $stmt = self::$pdo->prepare("SELECT * FROM baskets WHERE id_user = ? AND is_in_order = ?");
            $stmt->bindParam(1, $idUser);
            $stmt->bindParam(2, $isInOrder);
            $stmt->execute();
            $basket = $stmt->fetchAll();

            $goodArray = [];

            if($basket){

                foreach ($basket as $item){
                    array_push($goodArray, Good::getById($item['id_good']));
                }
            }

            return $goodArray;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function addItem()
    {
        OrderStatus::setStatus();

        try {
            //проверяем, есть ли уже запись в orders, чтоб не сделать вторую

            $stmt = self::$pdo->prepare("SELECT id FROM orders WHERE id_user = ? AND id_status = ? LIMIT 1");
            $stmt->bindParam(1, $this->idUser);
            $stmt->bindParam(2, OrderStatus::$formation);
            $stmt->execute();
            $data = $stmt->fetchAll();

            if(!$data){ //если нет - создаем запись в orders и записываем id_order в наш экземпляр

                try {

                    $stmt = self::$pdo->prepare("INSERT INTO orders SET id_user = ?, id_status = ?");
                    $stmt->bindParam(1, $this->idUser);
                    $stmt->bindParam(2, OrderStatus::$formation);
                    $stmt->execute();
                    $this->idOrder = self::$pdo->lastInsertId();

                } catch (Exception $e) {

                    die ('ERROR: ' . $e->getMessage());

                }
            }else{ //если есть - берем id_order и делаем запись в baskets
                $this->idOrder = $data[0]['id'];
            }

            //делаем запись теперь собственно в baskets

            try {

                $stmt = self::$pdo->prepare("INSERT INTO baskets SET id_user = ?, id_good = ?, id_order = ?, is_in_order = ?");
                $stmt->bindParam(1, $this->idUser);
                $stmt->bindParam(2, $this->idGood);
                $stmt->bindParam(3, $this->idOrder);
                $stmt->bindParam(4, $this->isInOrder);
                $stmt->execute();

                return true;

            } catch (Exception $e) {
                die ('ERROR: ' . $e->getMessage());
            }


        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function deleteFromBasket()
    {
        try {

            $stmt = self::$pdo->prepare("DELETE FROM baskets WHERE id_user = ? AND id_good = ? AND is_in_order = ? LIMIT 1");
            $stmt->bindParam(1, $this->idUser);
            $stmt->bindParam(2, $this->idGood);
            $stmt->bindParam(3, $this->isInOrder);
            $stmt->execute();

            return true;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}