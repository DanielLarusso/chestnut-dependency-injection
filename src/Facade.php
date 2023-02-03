<?php

declare(strict_types=1);

namespace Chestnut\DependencyInjection;

use Chestnut\Utils\AbstractFacade;

class Facade extends AbstractFacade
{
    public function getContainer(): Container
    {
        return $this->getFactory()->createContainer();
    }

    public function getContainerProxy(): ContainerProxy
    {
        return $this->getFactory()->createContainerProxy();
    }

    protected function createFactory(): Factory
    {
        return new Factory();
    }
}