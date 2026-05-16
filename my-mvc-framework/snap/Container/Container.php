<?php

declare(strict_types=1);

namespace snap\Container;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use RuntimeException;

class Container
{
    private array $bindings   = [];
    private array $singletons = [];
    private array $resolved   = [];

    public function bind(string $abstract, string|callable $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function singleton(string $abstract, string|callable $concrete): void
    {
        $this->singletons[$abstract] = $concrete;
    }

    public function resolve(string $abstract): object
    {
        if (isset($this->resolved[$abstract])) {
            return $this->resolved[$abstract];
        }

        if (isset($this->singletons[$abstract])) {
            $concrete = $this->singletons[$abstract];
            $instance = is_callable($concrete) ? $concrete($this) : $this->build($concrete);
            $this->resolved[$abstract] = $instance;
            return $instance;
        }

        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];
            return is_callable($concrete) ? $concrete($this) : $this->build($concrete);
        }

        return $this->build($abstract);
    }

    private function build(string $class): object
    {
        $reflection = new ReflectionClass($class);

        if (! $reflection->isInstantiable()) {
            throw new RuntimeException("Class [{$class}] is not instantiable.");
        }

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $dependencies = array_map(
            fn(ReflectionParameter $param) => $this->resolveParameter($param),
            $constructor->getParameters(),
        );

        return $reflection->newInstanceArgs($dependencies);
    }

    private function resolveParameter(ReflectionParameter $param): mixed
    {
        $type = $param->getType();

        if ($type instanceof ReflectionNamedType && ! $type->isBuiltin()) {
            return $this->resolve($type->getName());
        }

        if ($param->isDefaultValueAvailable()) {
            return $param->getDefaultValue();
        }

        throw new RuntimeException(
            "Cannot resolve parameter \${$param->getName()} "
            . "in [{$param->getDeclaringClass()?->getName()}]."
        );
    }
}
