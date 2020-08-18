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
    private const PARCEL_TRACKING_FILE_DIRECTORY = __DIR__ . '/../../../../data/parcel_tracking_files';

    /** @var Router\RouterInterface */
    private Router\RouterInterface $router;

    /**
     * HomePageHandler constructor.
     * @param Router\RouterInterface $router
     */
    public function __construct(Router\RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!is_null($request->getAttribute('parcel_id'))
            && file_exists(sprintf('%s/%s.json', self::PARCEL_TRACKING_FILE_DIRECTORY, $request->getAttribute('parcel_id')))
        ) {
            return new JsonResponse(
                json_decode(
                    file_get_contents(
                        sprintf('%s/%s.json', self::PARCEL_TRACKING_FILE_DIRECTORY, $request->getAttribute('parcel_id'))
                    )
                )
            );
        }

        return new JsonResponse([]);
    }
}
