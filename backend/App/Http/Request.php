<?php

    namespace App\Http;

    class Request{
        private array $body = [];

        public function __construct(
            private array $query,
            private array $request,
            private array $server,
            private array $files,
            private array $cookies,
        ){
            $this->parseBody();
        }

        public static function capture(): self{
            return new self($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
        }

        public function method(): string{
            return $this->server['REQUEST_METHOD'] ?? 'GET';
        }

        public function path(): string{
            $uri = $this->server['REQUEST_URI'] ?? '/';
            return strtok($uri, '?');
        }

        public function input(string $key, mixed $default = null): mixed{
            return $this->body[$key]
                ?? $this->request[$key]
                ?? $this->query[$key]
                ?? $default;
        }

        public function all(): array{
            return array_merge($this->query, $this->request, $this->body);
        }

        public function has(string $key): bool{
            return isset($this->body[$key])
                || isset($this->request[$key])
                || isset($this->query[$key]);
        }

        public function only(array $keys): array{
            return array_intersect_key($this->all(), array_flip($keys));
        }

        public function except(array $keys): array{
            return array_diff_key($this->all(), array_flip($keys));
        }

        public function file(string $key, mixed $default = null): mixed{
            return $this->files[$key] ?? $default;
        }

        public function cookie(string $key, mixed $default = null): mixed{
            return $this->cookies[$key] ?? $default;
        }

        public function header(string $key, mixed $default = null): mixed{
            $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
            return $this->server[$key] ?? $default;
        }

        public function bearerToken(): ?string{
            $header = $this->header('Authorization');

            if (!$header || !str_starts_with($header, 'Bearer ')) {
                return null;
            }

            return substr($header, 7);
        }

        private function parseBody(): void{
            $method = $this->method();
            $contentType = $this->server['CONTENT_TYPE'] ?? '';

            if (str_contains($contentType, 'application/json')) {
                $data = json_decode(file_get_contents('php://input'), true);
                if (is_array($data)) {
                    $this->body = $data;
                }
                return;
            }

            if (
                in_array($method, ['PUT', 'PATCH', 'DELETE']) &&
                str_contains($contentType, 'application/x-www-form-urlencoded')
            ) {
                parse_str(file_get_contents('php://input'), $data);
                $this->body = $data;
            }
        }
    }