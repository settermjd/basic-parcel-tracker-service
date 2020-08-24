<?php
declare(strict_types=1);

namespace App\Service;

use Teapot\StatusCode\RFC\RFC7231 as HttpStatusCodes;

/**
 * Class FileParcelTrackingService
 * @package App\Service
 */
final class FileParcelTrackingService extends AbstractParcelTrackingService implements ParcelTrackingService
{
    public const DIR = __DIR__ . '/../../../../data/results';

    /**
     * @inheritdoc
     */
    public function getErrorResponseBody(int $statusCode): array
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
     * @inheritdoc
     */
    public function getParcelData(string $pid): array
    {
        if ($this->isValidParcelTrackingNumber($pid)) {
            $parcelFile = $this->getParcelTrackingFilename(self::DIR, $pid);
            list($responseData, $responseCode) = $this->getParcelTrackingFileData($parcelFile);
        } else {
            $responseData = $this->getErrorResponseBody(HttpStatusCodes::EXPECTATION_FAILED);
            $responseCode = HttpStatusCodes::EXPECTATION_FAILED;
    }

    /**
     * @param string $parcelFile
     * @return bool
     */
    public function parcelTrackingFileIsAccessible(string $parcelFile): bool
    {
        return file_exists($parcelFile) && is_readable($parcelFile) && filesize($parcelFile);
    }

    /**
     * @param string $pid
     * @return array
     */
    public function getParcelData(string $pid): array
    {
        if ($this->isValidParcelTrackingNumber($pid)) {
            $parcelFile = $this->getParcelTrackingFile(self::DIR, $pid);
            list($responseData, $responseCode) = $this->getParcelTrackingFileData($parcelFile, self::DIR);
        } else {
            $responseData = $this->getErrorResponseBody(HttpStatusCodes::EXPECTATION_FAILED);
            $responseCode = HttpStatusCodes::EXPECTATION_FAILED;
        }

        return [$responseData, $responseCode];
    }

    /**
     * @param string $parcelFile
     * @param string $dir
     * @return array
     */
    public function getParcelTrackingFileData(string $parcelFile, string $dir): array
    {
        if ($this->parcelTrackingFileIsAccessible($parcelFile)) {
            $responseData = json_decode(file_get_contents($parcelFile));
            $responseCode = HttpStatusCodes::OK;
        } else {
            $responseData = $this->getErrorResponseBody(HttpStatusCodes::INTERNAL_SERVER_ERROR);
            $responseCode = HttpStatusCodes::INTERNAL_SERVER_ERROR;
        }

        return [
            $responseData,
            $responseCode
        ];
    }

    /**
     * @param string $dir
     * @param string $pid
     * @return string
     */
    private function getParcelTrackingFile(string $dir, string $pid): string
    {
        return sprintf('%s/%s.json', $dir, $pid);
    }
}
