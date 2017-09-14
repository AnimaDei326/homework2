<?php
namespace components;
//use components\Controller;

class Request implements ComponentInterface
{
    public $controller = 'news';
    public $action = 'index';
    public $nameSpaceController = '\controllers';

    public function init()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $path = explode('/', $uri);

        if(!empty($path[1])){
            $this->controller = $path[1];
        }

        if(count($path) == 3){
            if(!empty($path[2])){
                $this->action = $path[2];
            }
            if($newPath = strpbrk($path[count($path)-1], '?')){
                $this->action = str_replace($newPath, '', $path[count($path)-1]);
            }
        }


        $this->callController();
    }

    protected function callController()
    {
        $classController = $this->nameSpaceController . '\\' . ucwords($this->controller) . 'Controller';
        $action = 'action' . ucwords($this->action);

        if(class_exists($classController)){
            $controllerInstance = new $classController;

            if(method_exists($classController, $action)){
                call_user_func_array([$controllerInstance, $action], []);

                if( Controller::$title ){
                    $this->addHistory(); //если есть заголовок у страницы, запускаем метод записи истории
                }

            }else{
                throw  new \Exception('Error. Not exists calling method');
            }
            //unset($controllerInstance); //для подключения footer'a, он вызывается при уничтожении экземпляра
        }
    }
    public function addHistory()
    {

        $data = Session::getInstance();
        $pos = strripos($_SERVER['REQUEST_URI'], '/');
        $file = substr($_SERVER['REQUEST_URI'], $pos);

        if(!file_exists('views' .  $file . '.php')){ //не пишем историю, если файл существует

            if (!isset($data->cookie)) {

                $data->cookie = $_SERVER['REQUEST_URI'] . '$' . Controller::$title;

            } else {

                $array_cookie = explode('|', $data->cookie);

                if (count($array_cookie) >= 5) {

                    array_shift($array_cookie);

                }

                array_push($array_cookie, $_SERVER['REQUEST_URI'] . '$' . Controller::$title);

                $array_cookie_unique = array_unique($array_cookie);

                $str_cookie = implode('|', $array_cookie_unique);

                $data->cookie = $str_cookie;

            }
        }
    }

}