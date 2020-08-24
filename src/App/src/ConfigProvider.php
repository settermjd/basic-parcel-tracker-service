<?php

declare(strict_types=1);

namespace App;

use App\Handler\ParcelTrackingServiceHandler;
use App\Handler\ParcelTrackingServiceHandlerFactory;
use App\Middleware\Tideways\ServerTimingMiddleware;
use App\Service\FileParcelTrackingService;
use App\Service\ParcelTrackingService;
use Mezzio\Application;
use Mezzio\Container\ApplicationConfigInjectionDelegator;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes' => $this->getRouteConfig(),
            'templates' => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'aliases' => [
                ParcelTrackingService::class => FileParcelTrackingService::class,
            ],
            'factories'  => [
                ParcelTrackingServiceHandler::class => ParcelTrackingServiceHandlerFactory::class,
            ],
            'delegators' => [
                Application::class => [
                    ApplicationConfigInjectionDelegator::class,
                ],
            ],
            'invokables' => [
                ServerTimingMiddleware::class => ServerTimingMiddleware::class,
                FileParcelTrackingService::class => FileParcelTrackingService::class,
            ]
        ];
    }

    /**
     * Returns the module's routing table
     */
    public function getRouteConfig()
    {
        return [
            [
                'path' => '/parcel/v1/{parcel_id:[0-9A-Z]+}',
                'middleware' => ParcelTrackingServiceHandler::class,
                'allowed_methods' => ['GET'],
                'name' => 'getParcelById'
            ]
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
