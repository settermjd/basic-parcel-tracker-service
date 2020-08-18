<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class HomePageHandler
 * @package App\Handler
 */
class HomePageHandler implements RequestHandlerInterface
{
    private const DATA_FILE_DIR = __DIR__ . '/../../../../data/';

    /** @var Router\RouterInterface */
    private Router\RouterInterface $router;
    private $parcelTrackingDataFileDirectory;

    /**
     * HomePageHandler constructor.
     * @param Router\RouterInterface $router
     */
    public function __construct(Router\RouterInterface $router)
    {
        $this->router = $router;
        $this->parcelTrackingDataFileDirectory = self::DATA_FILE_DIR . 'parcel_tracking_files';
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!is_null($request->getAttribute('parcel_id'))
            && file_exists(sprintf('%s/%s.json', $this->parcelTrackingDataFileDirectory, $request->getAttribute('parcel_id')))
        ) {
            return new JsonResponse(
                json_decode(
                    file_get_contents(
                        sprintf('%s/%s.json', $this->parcelTrackingDataFileDirectory, $request->getAttribute('parcel_id'))
                    )
                )
            );
        }

        return new JsonResponse([]);
    }
}
