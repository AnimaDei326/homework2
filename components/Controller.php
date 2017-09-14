<?php
namespace components;
use Exception;
use models\User;

abstract class Controller
{
    static $title;

    public $layout = 'layout';
    public $params = [];
    public $replaceContainer = '<div class="content"></div>';

    public function render($view, $params = [])
    {

        if(!empty($params) && is_array($params)){
            $this->params = $params;
        }

        if( User::helloUser() ){
            $this->layout = 'layout_auth_user';
        }
        if( User::isManager() ) {
            $this->layout = 'layout_auth_manager';
        }
        if( User::isAdmin() ) {
            $this->layout = 'layout_auth_admin';
        }


        $fileLayout = App::BASE_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->layout . '.php';

        $fileView = App::BASE_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR .  $view . '.php';

        if(file_exists($fileLayout) && file_exists($fileView)){

            ob_start();
            require_once $fileLayout;
            $layoutHtml = ob_get_clean();

            ob_start();
            require_once $fileView;
            $viewHtml = ob_get_clean();

            $allHtml = str_replace($this->replaceContainer, $viewHtml, $layoutHtml);
            return $allHtml;

        }else{
            throw new Exception('Шаблон представления не найден'); //сделать 404.php
        }
    }

}