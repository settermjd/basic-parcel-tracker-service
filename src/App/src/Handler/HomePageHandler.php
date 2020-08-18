<?php

declare(strict_types=1);

namespace App\Handler;

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
        $parcelTrackingNumber = $request->getAttribute('parcel_id');
        try {
            $parcelTrackingFile = $this->getParcelTrackingFile($parcelTrackingNumber);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([], 404);
        }

        if ($this->parcelTrackingFileExists($parcelTrackingFile)) {
            return new JsonResponse(
                json_decode(
                    file_get_contents($parcelTrackingFile)
                )
            );
        }

        return new JsonResponse([]);
    }

    /**
     * @param string $parcelTrackingNumber
     * @throws InvalidArgumentException
     * @return string
     */
    private function getParcelTrackingFile(string $parcelTrackingNumber): string
    {
        $parcelTrackingFile = sprintf(
            '%s/%s.json',
            $this->parcelTrackingDataFileDirectory,
            $parcelTrackingNumber
        );

        if (! file_exists($parcelTrackingFile)) {
            throw new InvalidArgumentException('Parcel tracking file does not exist');
        }

        return $parcelTrackingFile;
    }

    /**
     * @param string $parcelTrackingFile
     * @return bool
     */
    private function parcelTrackingFileExists(string $parcelTrackingFile): bool
    {
        return file_exists($parcelTrackingFile);
    }
}
