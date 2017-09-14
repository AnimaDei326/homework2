<?php

namespace controllers;
use components\Controller;
use models\OrderStatus;
use models\User;
use models\Order;

class OrderController extends Controller
{
    public function actionIndex()
    {
        if( User::helloUser() ){

            self::$title = 'Оформление заказа';

            echo $this->render('order', [
                'title' => self::$title,
            ]);

        }else{
            Header('Location: /user/check');
        }

    }

    public function actionOpen()
    {
        if ($idUser = User::helloUser()) {

            if(isset($_POST['address'])){

                $address = strip_tags(trim($_POST['address']));
                $comment = '';

                if(isset($_POST['address'])) {

                    $comment = strip_tags(trim($_POST['comment']));

                }

                $order = new Order($idUser);
                if( $order->openOrder($comment, $address) ){

                    self::$title = 'Заказ оформлен';
                    $text = 'Спасибо за Ваш заказ! В скором времени наш раб с Вами свяжется';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);
                }else{

                    self::$title = 'Ошибка оформления заказа';
                    $text = 'Заказ не был оформлен. Повторите попытку, при повторной ошибке свяжетсь с нами.';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);
                }
            }

        } else {
            Header('Location: /user/check');
        }
    }

    public function actionShowOpen()
    {
        if( User::isManager() ){

            OrderStatus::setStatus();

            $orders = Order::showOrders(OrderStatus::$opened);

            self::$title = 'Открытые заказы';

            echo $this->render('order_manager', [
                'title' => self::$title,
                'orders' => $orders,
            ]);

        }else{
            Header('Location: /user/check');
        }
    }

    public function actionShowClose()
    {
        if( User::isManager() ){

            OrderStatus::setStatus();

            $orders = Order::showOrders(OrderStatus::$closed);

            self::$title = 'Закрытые заказы';

            echo $this->render('order_manager', [
                'title' => self::$title,
                'orders' => $orders,
            ]);

        }else{
            Header('Location: /user/check');
        }
    }

    public function actionDetail()
    {
        if( User::isManager() ){

            if(isset($_GET['id'])) {

                $idOrder = strip_tags(trim($_GET['id']));
                $goodsArray = Order::showGoods($idOrder);
                $orderInfo = Order::getOrderById($idOrder);

                self::$title = 'Детали заказа';
                echo $this->render('basket_manager', [
                    'title' => self::$title,
                    'basket' => $goodsArray,
                    'order' => $orderInfo,
                ]);
            }else{
                Header('Location: /order/all');
            }

        }else{
            Header('Location: /user/check');
        }
    }
    public function actionDetails() //для пользователей
    {
        if( $idUser = User::helloUser() ){

            if(isset($_GET['id'])) {

                $idOrder = strip_tags(trim($_GET['id']));
                $order = new Order($idUser);
                $goodsArray = $order->showGoodsForUser($idOrder);
                $orderInfo = Order::getOrderById($idOrder);

                self::$title = 'Детали моего заказа';
                echo $this->render('basket_my', [
                    'title' => self::$title,
                    'basket' => $goodsArray,
                    'order' => $orderInfo,
                ]);
            }else{
                Header('Location: /order/all');
            }

        }else{
            Header('Location: /user/check');
        }
    }
    public function actionClose()
    {
        if( User::isManager() ){

            if( isset($_GET['id']) ) {

                OrderStatus::setStatus();

                $idOrder = strip_tags(trim($_GET['id']));
                if( Order::setStatus($idOrder, OrderStatus::$closed) ){

                    self::$title = 'Закрытие заказа';
                    $text = 'Заказ успешно закрыт.';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);
                }
            }else{
                Header('Location: /order/all');
            }
        }else{
            Header('Location: /user/check');
        }
    }
    public function actionOpenAgain()
    {
        if( User::isManager() ){

            if( isset($_GET['id']) ) {

                OrderStatus::setStatus();
                $idOrder = strip_tags(trim($_GET['id']));
                if( Order::setStatus($idOrder, OrderStatus::$opened) ){

                    self::$title = 'Повторное открытие заказа';
                    $text = 'Заказ успешно заново открыт.';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);
                }
            }else{
                Header('Location: /order/all');
            }
        }else{
            Header('Location: /user/check');
        }
    }
    public function actionMyOrder()
    {
        if( $idUser = User::helloUser() ){

            OrderStatus::setStatus();

            $order = new Order($idUser);

            $orders = $order->showMyOrders();

            self::$title = 'Мои заказы';

            echo $this->render('order_my', [
                'title' => self::$title,
                'orders' => $orders,
            ]);

        }else{
            Header('Location: /user/check');
        }
    }
}