<?php
namespace controllers;
use models\Good;
use models\User;
use models\Catalog;

use components\Controller;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        if( User::isManager() ){

            $catalogs = Catalog::showCatalog(true);

            self::$title = 'Каталог';
            echo $this->render('catalog_manager', [
                'title' => self::$title,
                'catalogs' => $catalogs,
            ]);

        }else{
            Header('Location: /user/check');
        }

    }

    public function actionAdd()
    {
        if( User::isManager() ){

            self::$title = 'Новый раздел каталога';
            echo $this->render('add_catalog', [
                'title' => self::$title,
            ]);

        }else{
            Header('Location: /user/check');
        }

    }

    public function actionRename()
    {
        if( User::isManager() ){

            if(isset($_GET['id'])) {

                $id = strip_tags(trim($_GET['id'])) * 1;

                if ($catalogItem = Catalog::getById($id)) {

                    self::$title = 'Переименовать раздел каталога';
                    echo $this->render('rename_catalog', [
                        'title' => self::$title,
                        'item' => $catalogItem,
                    ]);

                } else {
                    Header('Location: /catalog');
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

                if ($catalogItem = Catalog::getById($id)) {

                    self::$title = 'Удалить раздел каталога';
                    echo $this->render('delete_catalog', [
                        'title' => self::$title,
                        'item' => $catalogItem,
                    ]);

                } else {
                    Header('Location: /catalog');
                }
            }

        }else{
            Header('Location: /user/check');
        }

    }



    public function actionAdding()
    {
        if( User::isManager() ){

            if(isset($_POST['catalogName'])){

                $nameCatalog = strip_tags(trim($_POST['catalogName']));

            }else{

                $nameCatalog = 'Новый каталог';

            }
                $catalog = new Catalog($nameCatalog);

                if($catalog->addCatalog()){

                    self::$title = 'Добавлен новый раздел каталога';
                    $text = 'Новый каталог "' . $catalog->name .  '" успешно добавлен!';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);

                }else{

                    self::$title = 'Ошибка при добавлении каталога';

                    $text = 'Каталог не добавлен. Повторите попытку, при повторении ошибки обратитесь к Администратору';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);
                }

        }else{
            Header('Location: /user/check');
        }

    }
    public function actionRenaming()
    {
        if( User::isManager() ){

            if(isset($_POST['catalogName'])){

                $nameCatalog = strip_tags(trim($_POST['catalogName']));

            }else{

                $nameCatalog = 'Новое имя каталога';

            }
            if(!isset($_POST['id'])){

                Header('Location: /catalog');

            }else {

                $id = strip_tags(trim($_POST['id']));
                $catalog = new Catalog($nameCatalog);
                $itemById = Catalog::getById($id);
                $catalog->id = $itemById[0]['id'];

                if ($catalog->renameCatalog()) {

                    self::$title = 'Изменение имени каталога';
                    $text = 'Каталог "' . $catalog->name . '" был успешно переименован!';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);

                } else {

                    self::$title = 'Ошибка при изменении имени каталога';

                    $text = 'Каталог не переименован. Повторите попытку, при повторении ошибки обратитесь к Администратору';

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
    public function actionDeleting()
    {
        if( User::isManager() ){

            if(!isset($_POST['id'])){

                Header('Location: /catalog');

            }else {
                $catalogName = 'Каталог';

                if(isset($_POST['catalog_name'])){
                    $catalogName = strip_tags(trim($_POST['catalog_name']));
                }

                $id = strip_tags(trim($_POST['id']));

                $itemById = Catalog::getById($id);
                $catalog = new Catalog($catalogName);
                $catalog->id = $itemById[0]['id'];

                if ($catalog->deleteCatalog()) {

                    self::$title = 'Удаление каталога';
                    $text = 'Каталог "' . $catalog->name . '" был успешно удален!';

                    echo $this->render('notification', [
                        'title' => self::$title,
                        'text' => $text,
                    ]);

                } else {

                    self::$title = 'Ошибка при изменении удалении каталога';

                    $text = 'Каталог не удален. Проверьте, удалены ли все товары данного каталога! Повторите попытку, при повторении ошибки обратитесь к Администратору';

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
    public function actionDetail()
    {
        if (User::isManager()) {

            if (isset($_GET['id'])) {

                $id = strip_tags(trim($_GET['id'])) * 1;

                $goodItems = Good::getByIdCategory($id);

                self::$title = 'Просмотр товаров каталога';

                echo $this->render('detail_catalog_manager', [
                    'title' => self::$title,
                    'goods' => $goodItems,
                ]);

            } else {
                Header('Location: /catalog');
            }
        } else {
            Header('Location: /catalog');
        }

    }
}