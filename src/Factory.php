<?php

declare(strict_types=1);

namespace Chestnut\DependencyInjection;

use Chestnut\Utils\AbstractFactory;

class Factory extends AbstractFactory
{
    public function createContainer(): Container
    {
        return Container::getInstance();
    }
    public function createContainerProxy(): ContainerProxy
    {
        return new ContainerProxy($this->createContainer());
    }

    public function createContainerBuilder(): ContainerBuilder
    {
        return new ContainerBuilder();
    }
}