<?php

namespace controllers;
use components\Controller;
use models\Catalog;
use models\User;
use models\Good;
use components\App;

class GoodController extends Controller
{
    public function actionIndex()
    {
        $goods = Good::showGood(true);

        self::$title = 'Товары';
        echo $this->render('good', [
            'title' => self::$title,
            'goods' => $goods,
        ]);

    }
    public function actionAdd()
    {
        if( User::isManager() ){

            $catalogs = Catalog::showCatalog(true);

            self::$title = 'Новый товар';
            echo $this->render('add_good', [
                'title' => self::$title,
                'catalogs' =>$catalogs,
            ]);

        }else{
            Header('Location: /user/check');
        }

    }
    public function actionAll()
    {
        if( User::isManager() ){

            $goods = Good::showGood(true);

            self::$title = 'Товары';
            echo $this->render('good_manager', [
                'title' => self::$title,
                'goods' => $goods,
            ]);

        }else{
            Header('Location: /user/check');
        }



    }
    public function actionDetail()
    {

        if(isset($_GET['id'])) {

            $id = strip_tags(trim($_GET['id'])) * 1;

            if ($goodItem = Good::getById($id)) {

                self::$title = $goodItem[0]['good_name'];

                echo $this->render('detail_good', [
                    'title' => self::$title,
                    'item' => $goodItem,
                ]);

            } else {
                Header('Location: /good/all');
            }
        }else {
            Header('Location: /good/all');
        }


    }
    public function actionAdding()
    {
        if( User::isManager() ){

            if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['id_category'])){

                $name = strip_tags(trim($_POST['name']));
                $description = strip_tags(trim($_POST['description']));
                $price = strip_tags(trim($_POST['price']));
                $idCategory = strip_tags(trim($_POST['id_category']));
                $good = new Good($name, $price, $description, $idCategory);


                if($good->addGood()){

                    self::$title = 'Добавлен новый товар';
                    $text = 'Новый товар "' . $good->name .  '" успешно добавлен!';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);

                }else{

                    self::$title = 'Ошибка при добавлении товара';

                    $text = 'Товар не добавлен. Повторите попытку, при повторении ошибки обратитесь к Администратору';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);
                }
            }

        }else{
            Header('Location: /user/check');
        }

    }
    public function actionDelete()
    {
        if( User::isManager() ){

            if(isset($_GET['id'])) {

                $id = strip_tags(trim($_GET['id'])) * 1;

                if ($goodItem = Good::getById($id)) {

                    self::$title = 'Удалить товар';
                    echo $this->render('delete_good', [
                        'title' => self::$title,
                        'item' => $goodItem,
                    ]);

                } else {
                    Header('Location: /good');
                }
            }

        }else{
            Header('Location: /user/check');
        }

    }
    public function actionDeleting()
    {
        if( User::isManager() ){

            if(!isset($_POST['id'])){

                Header('Location: /good');

            }else {
                $goodName = 'Товар';

                if(isset($_POST['good_name'])){
                    $goodName = strip_tags(trim($_POST['good_name']));
                }

                $id = strip_tags(trim($_POST['id']));

                $itemById = Good::getById($id);

                $good = new Good($goodName, '', '', '');

                $good->id = $itemById[0]['id'];

                $file = $itemById[0]['path']; //запоминаем старое имя файла

                if ($good->deleteGood()) {

                    if (isset($_POST['delete_old_file'])) {

                        if ($file != 'null.png' && file_exists('images/' . $file)) {

                            unlink('images/' . $file);
                        }
                    }

                    self::$title = 'Удаление товара';
                    $text = 'Товар "' . $good->name . '" был успешно удален!';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);

                } else {

                    self::$title = 'Ошибка при изменении удалении товара';

                    $text = 'Товар не удален. Повторите попытку, при повторении ошибки обратитесь к Администратору';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);
                }
            }

        }else{
            Header('Location: /user/check');
        }

    }
    public function actionRename()
    {
        if( User::isManager() ){

            if(isset($_GET['id'])) {

                $id = strip_tags(trim($_GET['id'])) * 1;

                if ($goodItem = Good::getById($id)) {

                    $catalogs = Catalog::showCatalog(true);

                    self::$title = 'Переименовать товар';
                    echo $this->render('rename_good', [
                        'title' => self::$title,
                        'item' => $goodItem,
                        'catalogs' => $catalogs,

                    ]);

                } else {
                    Header('Location: /good');
                }
            }

        }else{
            Header('Location: /user/check');
        }

    }
    public function actionRenaming()
    {
        if (User::isManager()) {

            if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['id_category'])) {

                $name = strip_tags(trim($_POST['name']));
                $description = strip_tags(trim($_POST['description']));
                $price = strip_tags(trim($_POST['price']));
                $id = strip_tags(trim($_POST['id']));
                $idCategory = strip_tags(trim($_POST['id_category']));

                $itemById = Good::getById($id);
                $good = new Good($name, $price, $description, $idCategory);
                $good->id = $itemById[0]['id'];

                $file = $itemById[0]['path']; //запоминаем старое имя файла

                if ($good->renameGood()) {

                    if (isset($_POST['delete_old_file'])) {

                        if ($file != 'null.png' && file_exists('images/' . $file)) {

                            unlink('images/' . $file);
                        }
                    }

                    self::$title = 'Изменение данных товара';
                    $text = 'Данные товара "' . $good->name . '" были успешно изменены!';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);

                } else {

                    self::$title = 'Ошибка при изменении данных товара';

                    $text = 'Данные товара не изменены. Повторите попытку, при повторении ошибки обратитесь к Администратору';

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

}