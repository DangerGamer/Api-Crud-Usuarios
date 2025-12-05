<?php
namespace App\core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void {
        $method = strtoupper($method);
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void {
        $method = strtoupper($method);

        $uriPath = parse_url($uri, PHP_URL_PATH);
        $scriptName = dirname($_SERVER['SCRIPT_NAME']); 

        $pattern = '#^' . preg_quote($scriptName, '#') . '#';
        $path = preg_replace($pattern, '', $uriPath);
        $path = '/' . ltrim($path, '/');

        header('Content-Type: application/json; charset=utf-8');

        if (isset($this->routes[$method][$path])) {
            call_user_func($this->routes[$method][$path]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Ruta no encontrada']);
        }
    }

}
