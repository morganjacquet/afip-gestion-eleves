<?php
require_once('../Core/Model.php');
require_once('../Core/Controller.php');

include('../App/config/app.php');

define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
define('PROJECT_PATH', $app_config['path']);

$params = explode('/', $_GET['p']);

if ($params[0] != "") {
    $controller = ucfirst($params[0]);

    $action = isset($params[1]) ? $params[1] : 'index';
    
    if (file_exists('../App/Controller/'.$controller.'.php')) {
        require_once('../App/Controller/'.$controller.'.php');

        $controller_path = 'App\Controller\\' . $controller;
        
        $controller = new $controller_path();
        if (method_exists($controller, $action)) {
            unset($params[0]);
            unset($params[1]);

            call_user_func_array([$controller,$action], $params);  
        } else {
            http_response_code(404);
            echo "Erreur 404 - La page est introuvable";
        }
    } else {
        http_response_code(404);
        echo "Erreur 404 - La page est introuvable";
    }
} else {
    require_once('../App/Controller/Home.php');

    $controller = new App\Controller\Home();

    $controller->index();
}