<?php

    namespace App\Core;

    use App\Http\Request;
    use App\Http\Response;
use ReflectionClass;

    class Router{
        private array $routes = [];

        public function add(string $method, string $path, callable|array $action, array $middleware = []):void{
            $this->routes[] = compact('method', 'path', 'action', 'middleware');
        }

        public function dispatch(Request $request){
            $path = $request->path();
            $method = $request->method();

            foreach($this->routes as $route){
                if(strtoupper($method) !== strtoupper($route['method'])){
                    continue;
                }

                $regex = $this->convertRoutePathToRegex($route['path']);
                if(preg_match($regex, $path, $matches)){
                    array_shift($matches);
                    foreach($route['middleware'] as $middlewareClass){
                        $middleware = new $middlewareClass;
                        $middleware->handle($request);
                    }

                    if(is_array($route['action'])){
                        [$controller, $methodName] = $route['action'];

                        $reflection = new ReflectionClass($controller);
                        $constructor = $reflection->getConstructor();

                        if ($constructor && $constructor->getNumberOfParameters() > 0) {
                            $controllerInstance = new $controller($request);
                        }
                        else{
                            $controllerInstance = new $controller();
                        }

                        call_user_func_array([$controllerInstance, $methodName], $matches);
                        return;
                    }
                    elseif(is_callable($route['action'])){
                        call_user_func_array($route['action'], $matches);
                        return;
                    }
                }
            }
            $response = new Response();
            $response->cors()->json(['error' => 'Route not found'], 404)->send();
        }

        private function convertRoutePathToRegex(string $routePath):string{
            $regex = preg_replace('#\{[a-zA-Z_]+\}#', '([a-zA-Z0-9_-]+)', $routePath);
            return "#^$regex$#";
        }

    }