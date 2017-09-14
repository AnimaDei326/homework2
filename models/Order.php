<?php
namespace models;
use components\App;
use Exception;

class Order
{
    public $id;
    public $idUser;
    public $comment;
    public $dateCreated;
    public $price;
    public $address;
    public $idStatus;

    public static $pdo = null;

    public function __construct($idUser)
    {
        $this->idUser = $idUser;

    }
    public function openOrder($comment, $address)
    {
        OrderStatus::setStatus();

        $this->idStatus = OrderStatus::$opened;
        $this->comment = $comment;
        $this->address = $address;
        $this->dateCreated = date('Y-m-d H:i:s');

        self::$pdo = App::$app->db->getConnect();

        $goodArray = Basket::showBasket($this->idUser, 0); //собираем все товары пользователя из корзины

        if(!$goodArray){
            return false; //чтобы пользователь никак не мог отправить пустой заказ
        }

        foreach ($goodArray as $items){
            foreach ($items as $item){
                $this->price += $item['price']; //формируем актуальную стоимость заказа
            }
        }

        try {

            $stmt = self::$pdo->prepare(
                "UPDATE orders SET comment = ?, address = ?, datetime_created = ?, price = ?,  id_status = ? WHERE id_status = ? LIMIT 1");
            $stmt->bindParam(1, $this->comment);
            $stmt->bindParam(2, $this->address);
            $stmt->bindParam(3, $this->dateCreated);
            $stmt->bindParam(4, $this->price);
            $stmt->bindParam(5, $this->idStatus);
            $stmt->bindParam(6, OrderStatus::$formation); //чтоб не обновить остальные заказы пользователя
            $stmt->execute();

            $isInOrder = 1;

            $stmt = self::$pdo->prepare(
                "UPDATE baskets SET is_in_order = ? WHERE id_user = ?");
            $stmt->bindParam(1, $isInOrder);
            $stmt->bindParam(2, $this->idUser);
            $stmt->execute();

            return true;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public static function showOrders($orderStatus)
    {
        self::$pdo = App::$app->db->getConnect();
        try {

            $stmt = self::$pdo->prepare("SELECT * FROM orders WHERE id_status = ?");
            $stmt->bindParam(1, $orderStatus);
            $stmt->execute();
            $orders = $stmt->fetchAll();

            return $orders;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }

    }
    public function showMyOrders()
    {
        self::$pdo = App::$app->db->getConnect();
        OrderStatus::setStatus();
        try {

            $stmt = self::$pdo->prepare("SELECT * FROM orders WHERE id_user = ? AND id_status != ?");
            $stmt->bindParam(1, $this->idUser);
            $stmt->bindParam(2, OrderStatus::$formation);
            $stmt->execute();
            $orders = $stmt->fetchAll();

            return $orders;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }

    }
    public static function showGoods($IdOrder)
    {
        self::$pdo = App::$app->db->getConnect();
        try {

            $stmt = self::$pdo->prepare("SELECT id_good FROM baskets WHERE id_order = ?");
            $stmt->bindParam(1, $IdOrder);
            $stmt->execute();
            $data = $stmt->fetchAll();

            $goodArray = [];

            if($data){

                foreach ($data as $item){
                    array_push($goodArray, Good::getById($item['id_good']));
                }
            }

            return $goodArray;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
    public function showGoodsForUser($IdOrder)
    {
        self::$pdo = App::$app->db->getConnect();
        try {

            $stmt = self::$pdo->prepare("SELECT id_good, id_user FROM baskets WHERE id_order = ? AND id_user = ?");
            $stmt->bindParam(1, $IdOrder);
            $stmt->bindParam(2, $this->idUser);
            $stmt->execute();
            $data = $stmt->fetchAll();

            $goodArray = [];

            if($data){

                foreach ($data as $item){
                    array_push($goodArray, Good::getById($item['id_good']));
                }
            }

            return $goodArray;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
    public static function getOrderById($idOrder)
    {
        self::$pdo = App::$app->db->getConnect();
        try {

            $stmt = self::$pdo->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->bindParam(1, $idOrder);
            $stmt->execute();
            $orders = $stmt->fetchAll();

            return $orders;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
    public static function setStatus($idOrder, $idStatus)
    {
        OrderStatus::setStatus();
        self::$pdo = App::$app->db->getConnect();

        try {

            $stmt = self::$pdo->prepare("UPDATE orders SET id_status = ? WHERE id = ? LIMIT 1");
            $stmt->bindParam(1, $idStatus);
            $stmt->bindParam(2, $idOrder);
            $stmt->execute();

            return true;

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }

    }

}