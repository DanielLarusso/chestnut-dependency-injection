<?php

declare(strict_types=1);

namespace Chestnut\DependencyInjection\Tests;

use Chestnut\DependencyInjection\Container;
use Chestnut\DependencyInjection\ContainerProxy;
use Chestnut\DependencyInjection\Facade;
use PHPUnit\Framework\TestCase;

class FacadeTest extends TestCase
{

    public function testGetContainer(): void
    {
        $facade = new Facade();
        $result = $facade->getContainer();

        $this->assertInstanceOf(Container::class, $result);
    }

    public function testGetContainerProxy(): void
    {
        $facade = new Facade();
        $result = $facade->getContainerProxy();

        $this->assertInstanceOf(ContainerProxy::class, $result);
    }
}
