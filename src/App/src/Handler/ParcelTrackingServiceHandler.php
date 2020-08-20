<?php

declare(strict_types=1);

namespace App\Handler;

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
    /**
     * Regex to determine a valid parcel id
     *
     * A valid parcel id must follow the format:
     *     TN + 9 digits + 2 character country code (ISO 3166-1 alpha-2)
     * An example code matching that format is: TN100036127AU
     *
     * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
     */
    private const VALID_PARCEL_ID = '/TN\d{9}[A-Z]{2}/';

    /** @var Router\RouterInterface */
    private Router\RouterInterface $router;

    /**
     * ParcelTrackingServiceHandler constructor.
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
        $responseCode = 200;

        if ($this->isValidParcelTrackingNumber($pid)) {
            if (file_exists(sprintf('%s/%s.json', $dir, $pid))) {
                $responseData = $this->getParcelData($dir, $pid);
            } else {
                $responseData = $this->getErrorResponseBody(500);
                $responseCode = 500;
            }
        } else {
            $responseData = $this->getErrorResponseBody(417);
            $responseCode = 417;
        }

        return new JsonResponse($responseData, $responseCode);
    }

    /**
     * @return array
     */
    private function getErrorResponseBody($statusCode): array
    {
        switch ($statusCode) {
            case 500:
                $message = 'Parcel Tracking Data is Not Available';
                break;
            case 417:
                $message = 'Missing Parcel Tracking Number';
                break;
            case 400:
                $message = 'Invalid Parcel Tracking Number';
                break;
            default:
                $message = 'Unknown Error';
        }

        return [
            'api_response' => $statusCode,
            'status' => $message
        ];
    }

    /**
     * @param string $dir
     * @param string $pid
     * @return string
     */
    private function getParcelData(string $dir, string $pid): string
    {
        return json_decode(
            file_get_contents(
                sprintf('%s/%s.json', $dir, $pid)
            )
        );
    }

    /**
     * @param $pid
     * @return bool
     */
    private function isValidParcelTrackingNumber($pid): bool
    {
        return preg_match(self::VALID_PARCEL_ID, $pid);
    }
}
