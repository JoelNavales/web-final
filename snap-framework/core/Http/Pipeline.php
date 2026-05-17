<?php

declare(strict_types=1);

namespace core\Http;

class Pipeline
{
    private array $layers = [];

    public function pipe(Middleware $middleware): static
    {
        $this->layers[] = $middleware;
        return $this;
    }

    public function run(Request $request, callable $destination): Response
    {
        $pipeline = array_reduce(
            array_reverse($this->layers),
            fn(callable $next, Middleware $mw) => fn(Request $req) => $mw->handle($req, $next),
            $destination,
        );

        return $pipeline($request);
    }
}
