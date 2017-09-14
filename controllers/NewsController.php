<?php
namespace controllers;
use components\Controller;


class NewsController extends Controller
{
    public function actionIndex()
    {
        self::$title = 'Новости';

        echo $this->render('news', [
                'title' => self::$title,
        ]);

    }
}