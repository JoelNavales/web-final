<?php

declare(strict_types=1);

namespace snap\Http;

class Request
{
    public readonly string $method;
    public readonly string $uri;
    public readonly string $path;
    public readonly array  $query;
    public readonly array  $body;
    public readonly array  $params;

    public function __construct(array $params = [])
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->uri    = $_SERVER['REQUEST_URI'] ?? '/';
        $this->path   = parse_url($this->uri, PHP_URL_PATH) ?? '/';
        $this->query  = $_GET;
        $this->body   = $_POST;
        $this->params = $params;
    }

    public function withParams(array $params): static
    {
        return new static($params);
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->query, $this->body);
    }
}
