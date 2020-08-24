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

    /**
     * @return array
     */
    public function getErrorResponseBody($statusCode): array
    {
        return $this->fileParcelTrackingService->getErrorResponseBody($statusCode);
    }

    /**
     * @param string $parcelFile
     * @return string
     */
    public function getParcelData(string $parcelFile): string
    {
        return $this->fileParcelTrackingService->getParcelData($parcelFile);
    }

    /**
     * @param $pid
     * @return bool
     */
    public function isValidParcelTrackingNumber($pid): bool
    {
        return $this->fileParcelTrackingService->isValidParcelTrackingNumber($pid);
    }

    /**
     * @param string $parcelFile
     * @param string $dir
     * @return array
     */
    public function getParcelTrackingFileData(string $parcelFile, string $dir): array
    {
        return $this->fileParcelTrackingService->getParcelTrackingFileData($parcelFile, $dir);
    }

    /**
     * @param string $parcelFile
     * @return bool
     */
    public function parcelTrackingFileIsAccessible(string $parcelFile): bool
    {
        return $this->fileParcelTrackingService->parcelTrackingFileIsAccessible($parcelFile);
    }

    /**
     * @param string $pid
     * @param string $dir
     * @return array
     */
    public function getParcelTrackingData(string $pid, string $dir): array
    {
        return $this->fileParcelTrackingService->getParcelTrackingData($pid, $dir);
    }
}
