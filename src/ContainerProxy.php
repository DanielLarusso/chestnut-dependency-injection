<?php

declare(strict_types=1);

namespace Chestnut\DependencyInjection;

use Psr\Container\ContainerInterface;

class ContainerProxy implements ContainerInterface
{
    protected static array $cache = [];

    public function __construct(protected readonly Container $container)
    {
    }

    public function get(string $id)
    {
        return self::$cache[$id] ?? self::$cache[$id] = $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }

    public function set(string $id, callable|string $concrete): self
    {
        $this->container->set($id, $concrete);

        return $this;
    }

    public function resolve(string $id): object
    {
        return $this->container->resove($id);
    }
}
