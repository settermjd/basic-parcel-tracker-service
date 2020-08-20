<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\ParcelTrackingServiceHandler;
use App\Handler\ParcelTrackingServiceHandlerFactory;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;

class HomePageHandlerFactoryTest extends TestCase
{
    /** @var ContainerInterface|ObjectProphecy */
    protected $container;

    protected function setUp() : void
    {
        $this->container = $this->prophesize(ContainerInterface::class);
        $router = $this->prophesize(RouterInterface::class);

        $this->container->get(RouterInterface::class)->willReturn($router);
    }

    public function testFactoryWithoutTemplate()
    {
        $factory = new ParcelTrackingServiceHandlerFactory();
        $this->container->has(TemplateRendererInterface::class)->willReturn(false);

        $this->assertInstanceOf(ParcelTrackingServiceHandlerFactory::class, $factory);

        $homePage = $factory($this->container->reveal());

        $this->assertInstanceOf(ParcelTrackingServiceHandler::class, $homePage);
    }

    public function testFactoryWithTemplate()
    {
        $this->container->has(TemplateRendererInterface::class)->willReturn(true);
        $this->container
            ->get(TemplateRendererInterface::class)
            ->willReturn($this->prophesize(TemplateRendererInterface::class));

        $factory = new ParcelTrackingServiceHandlerFactory();

        $homePage = $factory($this->container->reveal());

        $this->assertInstanceOf(ParcelTrackingServiceHandler::class, $homePage);
    }
}
