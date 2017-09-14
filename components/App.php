<?php
namespace components;

class App
{
    /**
     * @var null|App
     */
    public static $app = null; //синглтон нашего приложения
    public $request = null; //компонент, который обрабатывает запросы
    public $db = null; //компонент бд

    const BASE_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..';

    public function __construct()
    {
        $this->request = new Request();
        $this->db = new Db();
    }

    public static function run()
    {
        if(self::$app == null)
        {
            self::$app = new App();
            self::$app->db->init();
            self::$app->request->init();
        }
        return self::$app;
    }

}