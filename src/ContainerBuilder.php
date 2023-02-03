<?php

declare(strict_types=1);

namespace Chestnut\DependencyInjection;

class ContainerBuilder implements ContainerBuilderInterface
{
    public function add(string $key, array $options): static
    {
        return $this;
    }
}