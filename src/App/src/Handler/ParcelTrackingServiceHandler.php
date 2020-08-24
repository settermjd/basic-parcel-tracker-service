<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\FileParcelTrackingService;
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
    /** @var FileParcelTrackingService */
    private $fileParcelTrackingService;

    /**
     * ParcelTrackingServiceHandler constructor.
     * @param Router\RouterInterface $router
     */
    public function __construct(Router\RouterInterface $router)
    {
        $this->router = $router;
        $this->fileParcelTrackingService = new FileParcelTrackingService();
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pid = $request->getAttribute('parcel_id');

        list($responseData, $responseCode) = $this->getParcelTrackingData($pid, $dir);

        return new JsonResponse($responseData, $responseCode);
    }
}
