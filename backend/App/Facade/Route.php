<?php

    namespace App\Facade;
    use App\Core\Router;

    class Route{
        private static Router $router;

        public static function setRouter(Router $router):void{
            self::$router = $router;
        }
        public static function get(string $path, callable|array $action, array $middleware = []):void{
            self::$router->add("GET", $path, $action, $middleware);
        }

        public static function post(string $path, callable|array $action, array $middleware = []):void{
            self::$router->add('POST', $path, $action, $middleware);
        }

        public static function put(string $path, callable|array $action, array $middleware = []):void{
            self::$router->add('PUT', $path, $action, $middleware);
        }

        public static function delete(string $path, callable|array $action, array $middleware = []):void{
            self::$router->add('DELETE', $path, $action, $middleware);
        }

        public static function any(string $path, callable|array $action, array $middleware = []):void{
            foreach (['GET','POST','PUT','DELETE','PATCH','OPTIONS'] as $method) {
                self::$router->add($method, $path, $action, $middleware);
            }
        }
    }
