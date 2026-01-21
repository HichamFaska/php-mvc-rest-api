<?php

    namespace App\Http;

    class Request{
        private array $json = [];

        public function __construct(
            private array $query,
            private array $request,
            private array $server,
            private array $files,
            private array $cookies,
        ){
            $this->parseJson();
        }

        public static function capture():Request{
            return new Request($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
        }

        public function method():string{
            return $this->server["REQUEST_METHOD"] ?? "GET";
        }

        public function path():string{
            $uri = $this->server["REQUEST_URI"] ?? '/'; // /users/15/edit?q=php
            return strtok($uri, '?'); // // Retourne "/users/15/edit"
        }

        public function input(string $key, mixed $default = null):mixed{
            return $this->request[$key]
                ?? $this->query[$key]
                ?? $this->json[$key]
                ?? $default;
        }

        public function file(string $key, mixed $default = null):mixed{
            return $this->files[$key] ?? $default;
        }

        public function cookie(string $key, mixed $default = null):mixed{
            return $this->cookies[$key] ?? $default;
        }

        public function all():array{
            return array_merge($this->query, $this->request, $this->json);
        }

        public function has(string $key):bool{
            return isset($this->query[$key])
                || isset($this->requeste[$key])
                || isset($this->json[$key]);
        }
        
        public function header(string $key, mixed $default = null):mixed{
            $key = "HTTP_".strtoupper(str_replace('-','_',$key));
            return $this->server[$key] ?? $default;
        }

        public function bearerToken():?string{
            $header = $this->request["Authorization"];
            if(!$header){
                return null;
            }

            return str_starts_with($header, "Bearer ")
                ? substr($header, 7) : null;
        }

        public function parseJson():void{
            $contentType = $this->server['CONTENT_TYPE'] ?? '';
            if(str_contains($contentType, 'application/json')){
                $flux = file_get_contents("php://input");
                $data = json_decode($flux, true);
                if(is_array($data)){
                    $this->json = $data;
                }
            }
        }
    }