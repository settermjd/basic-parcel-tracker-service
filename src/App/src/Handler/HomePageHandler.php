<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\FileParcelTrackingService;
use App\Service\ParcelTrackingService;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Exception\InvalidArgumentException;
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

    /** @var ParcelTrackingService */
    private ParcelTrackingService $parcelService;

    /**
     * HomePageHandler constructor.
     * @param Router\RouterInterface $router
     * @param ParcelTrackingService $parcelTrackingService
     */
    public function __construct(Router\RouterInterface $router, ParcelTrackingService $parcelTrackingService)
    {
        $this->router = $router;
        $this->parcelService = $parcelTrackingService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $parcelTrackingFile = $this->parcelService->getTrackingFile($request->getAttribute('parcel_id'));
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([], 404);
        }

        if ($this->parcelService->hasTrackingFile($parcelTrackingFile)) {
            return new JsonResponse($this->parcelService->getParcelData($parcelTrackingFile));
        }

        return new JsonResponse([], 500);
    }
}
