<?php

declare(strict_types=1);

namespace Chestnut\DependencyInjection;

use Chestnut\DependencyInjection\Exceptions\ContainerException;
use Chestnut\Utils\AbstractSingleton;
use Psr\Container\ContainerInterface;

use ReflectionClass;

use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;
use Throwable;

use function array_map;
use function is_callable;
use function sprintf;

class Container extends AbstractSingleton implements ContainerInterface
{
    private array $services = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            if (is_callable($this->services[$id])) {
                return $this->services[$id]($this);
            }

            $id = $this->services[$id];
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }

    public function set(string $id, callable|string $concrete): self
    {
        if (!$this->has($id)) {
            $this->services[$id] = $concrete;
        }

        return $this;
    }

    public function resolve(string $id): object|string
    {
        try {
            $reflection = new ReflectionClass($id);
        } catch (Throwable $e) {
            return $id;
        }

        if (!$reflection->isInstantiable()) {
            throw new ContainerException(sprintf('Class "%s" is not instantiable', $id));
        }

        $parameters = $reflection->getConstructor()?->getParameters();

        if (0 >= $parameters) {
            return new $id();
        }

        return $reflection->newInstanceArgs($this->extractDependencies($parameters, $id));
    }

    private function extractDependencies(?array $parameters, string $id): array
    {
        return array_map(static function (ReflectionParameter $parameter) use ($id) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if (!$type instanceof ReflectionType) {
                throw new ContainerException(
                    sprintf(
                        'Failed to resolve class "%s" because param "%s" is not type hinted',
                        $id,
                        $name
                    )
                );
            }

            if ($type instanceof ReflectionUnionType) {
                throw new ContainerException(
                    sprintf(
                        'Failed to resolve class "%s" because param "%s" is a union type',
                        $id,
                        $name
                    )
                );
            }

            if ($type instanceof ReflectionNamedType) {
                if ($type->isBuiltin()) {
                    return $this->get($name);
                }

                return $this->get($type->getName());
            }

            throw new ContainerException(
                sprintf(
                    'Failed to resolve class "%s" because invalid param "%s"',
                    $id,
                    $name
                )
            );
        }, $parameters);
    }
}
