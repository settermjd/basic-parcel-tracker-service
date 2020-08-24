<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\ParcelTrackingService;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ParcelTrackingServiceHandler
 * @package App\Handler
 */
class ParcelTrackingServiceHandler implements RequestHandlerInterface
{
    /** @var Router\RouterInterface */
    private Router\RouterInterface $router;

    /**
     * @var ParcelTrackingService
     */
    private ParcelTrackingService $parcelTrackingService;

    /**
     * ParcelTrackingServiceHandler constructor.
     * @param Router\RouterInterface $router
     * @param ParcelTrackingService $parcelTrackingService
     */
    public function __construct(Router\RouterInterface $router, ParcelTrackingService $parcelTrackingService)
    {
        $this->router = $router;
        $this->parcelTrackingService = $parcelTrackingService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pid = $request->getAttribute('parcel_id');
        list($responseData, $responseCode) = $this->parcelTrackingService->getParcelData($pid);

        return new JsonResponse($responseData, $responseCode);
    }
}
