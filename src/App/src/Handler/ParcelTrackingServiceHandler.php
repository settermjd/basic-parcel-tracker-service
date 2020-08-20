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
        $dir = __DIR__ . '/../../../../data/results';
        $pid = $request->getAttribute('parcel_id');

        if (!is_null($pid)) {
            if (file_exists(sprintf('%s/%s.json', $dir, $pid))) {
                return new JsonResponse(
                    json_decode(
                        file_get_contents(
                            sprintf('%s/%s.json', $dir, $pid)
                        )
                    )
                );
            } else {
                return new JsonResponse(
                    [
                        'api_response' => 400,
                        'status' => 'Parcel Tracking Data is Not Available'
                    ],
                    400
                );
            }
        } else {
            return new JsonResponse(
                [
                    'api_response' => 400,
                    'status' => 'Missing Parcel Tracking Number'
                ],
                400
            );
        }
    }
}
