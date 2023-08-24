<?php

declare(strict_types=1);

namespace Chestnut\DependencyInjection\Tests;

use Chestnut\DependencyInjection\Container;
use Chestnut\DependencyInjection\ContainerProxy;
use Chestnut\DependencyInjection\Facade;
use Chestnut\DependencyInjection\Tests\Fixtures\Example;
use PHPUnit\Framework\TestCase;

class ContainerProxyTest extends TestCase
{
    public function test__construct(): void
    {
        $containerProxy = (new Facade())->getContainer();

        $this->assertInstanceOf(ContainerProxy::class, $containerProxy);
    }

    public function testHas(): void
    {
        $containerProxy = (new Facade())->getContainer();

        $this->assertTrue($containerProxy->has(Example::class));
        $this->expectException(ServiceNotFound::class);

        $containerProxy->has(InvalidExample::class);
    }

    public function testGet(): void
    {
        $containerProxy = (new Facade())->getContainer();
    }
}
