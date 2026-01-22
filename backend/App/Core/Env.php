<?php
    namespace App\Core;

    use RuntimeException;

    class Env{
        public static function load(string $path):void{
            if(!file_exists($path)){
                throw new RuntimeException("fichier .env introuvable.");
            }

            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach($lines as $line){
                $line = trim($line);
                if(str_starts_with($line, '#')){
                    continue;
                }
                if(!str_contains($line, '=')){
                    continue;
                }
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                $_ENV[$key] = $value;
            }
        }

        public static function get(string $key, mixed $default = null){
            return $_ENV[$key] ?? $default;
        }
    }
