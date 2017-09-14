<?php

namespace controllers;
use components\Controller;
use models\Basket;
use models\User;
use models\Good;

class BasketController extends Controller
{
    public function actionIndex()
    {
        if( $idUser =  User::helloUser() ){

            $basket = Basket::showBasket($idUser, 0);

            self::$title = 'Корзина';
            echo $this->render('basket', [
                'title' => self::$title,
                'basket' => $basket,
            ]);

        }else{
            Header('Location: /user/check');
        }

    }
    public function actionAdd()
    {
        if( $idUser = User::helloUser() ){

            if(isset($_GET['id'])){

                $id = strip_tags(trim($_GET['id']));
                $goodItem = Good::getById($id);

                if($goodItem){

                    if($goodItem[0]['status']){

                        $basket = new Basket($idUser, $goodItem[0]['id']);

                        if( $basket->addItem() ){

                            self::$title = 'Товар добавлен в корзину';

                            $text = 'Товар в корзине!' . '<br/><a class="myButton" href=\'\good\'>продолжить покупки</a><br/><a class="myButton" href=\'\basket\'>открыть корзину</a> ';

                            echo $this->render('notification', [
                                'title' => self::$title,
                                'text' => $text,
                            ]);

                        }else{

                            self::$title = 'Ошибка';

                            $text = 'Товар не был добавлен в корзину. Перезагрузите страницу и повторите попытку.';

                            echo $this->render('notification', [
                                'title' => self::$title,
                                'text' => $text,
                            ]);
                        }

                    }
                }
            }

        }else{

            self::$title = 'Уведомление';

            $text = 'Для покупок необходима авторизация. Пожалуйста, зайдите или зарегистрируйтесь';

            echo $this->render('notification', [
                'title' => self::$title,
                'text' => $text,
            ]);
        }
    }
    public function actionDelete()
    {
        if( $idUser =  User::helloUser() ){

            if(isset($_GET['id'])){

                $idGood = strip_tags(trim($_GET['id']));
                $basket = new Basket($idUser, $idGood);

                if( $basket->deleteFromBasket() ){
                    Header('Location: /basket');
                }

                $text = 'Товар не был удален из корзины. Повторите попытку, при повторе ошибки обратитесь к нам.';
                echo $this->render('notification', [
                    'text' => $text,
                ]);

            }else{
                Header('Location: /basket');
            }


        }else{
            Header('Location: /user/check');
        }

    }
}