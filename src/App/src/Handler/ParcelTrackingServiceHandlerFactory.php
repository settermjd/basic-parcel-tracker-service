<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\ParcelTrackingService;
use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function get_class;

class ParcelTrackingServiceHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $parcelTrackingService = $container->get(ParcelTrackingService::class);

        return new ParcelTrackingServiceHandler($router, $parcelTrackingService);
    }
}
