<?php

declare(strict_types=1);

namespace Chestnut\DependencyInjection;

use Psr\Container\ContainerInterface;

trait ContainerTrait
{
    protected function getContainer(): ContainerInterface
    {
        return Container::getInstance();
    }
}