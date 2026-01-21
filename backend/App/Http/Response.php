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
    }