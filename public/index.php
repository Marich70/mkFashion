<?php
session_start();

// Définir le chemin racine
define('ROOT_PATH', dirname(__DIR__));

// Autoload corrigé
spl_autoload_register(function ($class_name) {
    $paths = [
        ROOT_PATH . '/controllers/',
        ROOT_PATH . '/models/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Récupérer l'URL
$request = $_SERVER['REQUEST_URI'];

// Enlever le chemin de base
$base_path = '/mkFashion/public/';
if (strpos($request, 'api/') === 0) {
    $apiParts = explode('/', $request);
    $apiMethod = $apiParts[1] ?? '';
    
    if ($apiMethod === 'recent-orders') {
        require_once ROOT_PATH . '/controllers/ApiController.php';
        $api = new ApiController();
        $api->recentOrders();
        exit();
    }
}

if (strpos($request, $base_path) === 0) {
    $request = substr($request, strlen($base_path));
}

// Enlever les paramètres GET (?truc=chose)
if (strpos($request, '?') !== false) {
    $request = substr($request, 0, strpos($request, '?'));
}

// Nettoyer les slashes
$request = trim($request, '/');

// Si request est vide, on va à l'accueil
if (empty($request)) {
    $controllerName = 'ProductController';
    $action = 'index';
    $params = [];
} else {
    // Découper l'URL
    $parts = explode('/', $request);
    $controllerName = ucfirst($parts[0]) . 'Controller';
    $action = isset($parts[1]) ? $parts[1] : 'index';
    // Les paramètres sont ce qui reste après l'action
    $params = array_slice($parts, 2);
}

// Vérifier si le contrôleur existe
if (!class_exists($controllerName)) {
    die("❌ Controller '$controllerName' introuvable");
}

// Instancier le contrôleur
$controller = new $controllerName();

// Vérifier si la méthode existe
if (!method_exists($controller, $action)) {
    die("❌ Action '$action' introuvable dans $controllerName");
}

// Appeler la méthode avec les paramètres
$controller->$action(...$params);
?>