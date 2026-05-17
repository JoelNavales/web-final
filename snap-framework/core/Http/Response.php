<?php

declare(strict_types=1);

namespace core\Http;

class Response
{
    public function __construct(
        private string $body    = '',
        private int    $status  = 200,
        private array  $headers = [],
    ) {}

    public function setHeader(string $name, string $value): static
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function send(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
        echo $this->body;
    }

    public static function view(string $content, int $status = 200): static
    {
        return new static($content, $status);
    }

    public static function redirect(string $url, int $status = 302): static
    {
        return new static('', $status, ['Location' => $url]);
    }
}
