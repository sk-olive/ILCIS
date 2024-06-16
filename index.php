<?php

$env = "development";

if($env === "development") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
    if ($_SERVER["HTTPS"] != "on") {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
}

date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($className) {
    $controllerFile = __DIR__ . '/controllers/' . $className . '.php';
    $modelFile = __DIR__ . '/models/' . $className . '.php';
    $baseModelFile = __DIR__ . '/models/BaseModel.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
    }
    if (file_exists($modelFile)) {
        require_once $modelFile;
    }
    if (file_exists($baseModelFile)) {
        require_once $baseModelFile;
    }
});

$routes = require_once __DIR__ . '/routes.php';

$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

if (($pos = strpos($requestUri, '?')) !== false) {
    $requestUri = substr($requestUri, 0, $pos);
}

$matchedRoute = false;

foreach ($routes as $route => $handler) {

    $pattern = '#^' . preg_replace('#\{([\w]+)\}#', '([\d]+)', $route) . '$#';

    if (preg_match($pattern, $requestUri, $matches)) {
        $matchedRoute = true;

        array_shift($matches);

        [$controllerName, $action] = explode('@', $handler);
        $controllerName = ucfirst($controllerName) . 'Controller';

        if (class_exists($controllerName)) {
            $controller = new $controllerName();

            if (method_exists($controller, $action)) {
                $controller->$action(...$matches);
            } else {
                http_response_code(404);
                loadView('404.html');
                exit;
            }
        } else {
            http_response_code(404);
            loadView('404.html');
            exit;
        }
        break;
    }
}

if (!$matchedRoute) {
    http_response_code(404);
    loadView('404.html');
    exit;
}

function loadView($viewPath, $data = [])
{
    extract($data);
    $viewFile = __DIR__ . '/views/' . $viewPath . '.php';
    if (file_exists($viewFile)) {
        require_once $viewFile;
    } else {
        http_response_code(404);
        echo file_get_contents("views/404.html");
        exit;
    }
}
