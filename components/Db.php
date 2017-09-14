<?php
namespace components;
use PDO;

class Db implements ComponentInterface
{
    public $host = 'localhost';
    public $db = 'homework';
    public $user = 'root';
    public $password = '1111';
    public $port = '3306';
    public $charset = 'utf8';

    /**
     * @var null|PDO
     */

    private $pdo = null;

    public function init()
    {
        $dsn = 'mysql:host=' . $this->host . ':' . $this->port .
            ';dbname=' . $this->db .
            ';charset=' . $this->charset;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //для вывода исключений на экран
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //данные в виде асс. масива
        ];

        $this->pdo = new PDO($dsn, $this->user, $this->password, $options);
        return true;
    }

    /**
     * @return null|PDO
     */
    public function getConnect()
    {
        return $this->pdo;
    }

    function __destruct()
    {
        $this->pdo = null;
    }
}