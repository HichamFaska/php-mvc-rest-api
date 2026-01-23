<?php

    namespace App\Http;

    class Response{
        private string $content;
        private int $status;
        private array $headers = [];

        public function __construct($content = '', $status = 200, $headers = []){
            $this->content = $content;
            $this->status = $status;
            $this->headers = $headers;
        }

        public function send():void{
            http_response_code($this->status);
            
            // Ajouter les headers CORS s'ils ne sont pas déjà définis
            if(!isset($this->headers['Access-Control-Allow-Origin'])){
                $this->cors();
            }
            
            foreach($this->headers as $key => $value){
                header("{$key}: {$value}");
            }
            echo $this->content;
        }

        public function header(string $key, string $value):Response{
            $this->headers[$key] = $value;
            return $this;
        }

        public function status(int $status):Response{
            $this->status = $status;
            return $this;
        }

        public function json(array $data, int $status = 200){
            $this->content = json_encode($data, JSON_UNESCAPED_UNICODE);
            $this->status = $status;
            $this->header("Content-Type", "application/json");
            return $this;
        }

        public function redirect(string $uri, int $status = 302):void{
            $this->status = $status;
            $this->header('Location', $uri);
            $this->send();
            exit;
        }

        public function cors(string $origin = '*'):Response{
            $this->header('Access-Control-Allow-Origin', $origin);
            $this->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
            $this->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            $this->header('Access-Control-Allow-Credentials', 'true');
            return $this;
        }
    }