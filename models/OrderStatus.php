<?php

namespace models;
use components\App;
use Exception;

//устанавливаем в статические переменные id для статусов заказов,
// чтоб в случае изменений в бд поменять их только в одном месте

class OrderStatus
{
    public static $formation;
    public static $opened;
    public static $closed;

    public static $pdo = null;

    public static function setStatus()
    {
        if( self::$pdo == null ) {

            self::$pdo = App::$app->db->getConnect();

            try {
                $stmt = self::$pdo->prepare("SELECT * FROM order_status");
                $stmt->execute();
                $data = $stmt->fetchAll();
                foreach ($data as $item) {
                    switch ($item['name']) {
                        case 'formation' :
                            self::$formation = $item['id'];
                            break;
                        case 'opened' :
                            self::$opened = $item['id'];
                            break;
                        case 'closed' :
                            self::$closed = $item['id'];
                            break;
                    }
                }
            } catch (Exception $e) {
                die ('ERROR: ' . $e->getMessage());
            }
        }
    }
}