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
    private const PARCEL_TRACKING_FILE_DIRECTORY = __DIR__ . '/../../../../data/results';

    /**
     * @inheritdoc
     */
    public function getErrorResponseBody(int $statusCode): array
    {
        switch ($statusCode) {
            case HttpStatusCodes::INTERNAL_SERVER_ERROR:
                $message = 'Parcel Tracking Data is Not Available';
                break;
            case HttpStatusCodes::EXPECTATION_FAILED:
                $message = 'Missing Parcel Tracking Number';
                break;
            case HttpStatusCodes::BAD_REQUEST:
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
    public function getParcelData(string $parcelTrackingNumber): array
    {
        if ($this->isValidParcelTrackingNumber($parcelTrackingNumber)) {
            $parcelFile = $this->getParcelTrackingFilename($parcelTrackingNumber);
            list($responseData, $responseCode) = $this->getParcelTrackingFileData($parcelFile);
        } else {
            $responseData = $this->getErrorResponseBody(HttpStatusCodes::EXPECTATION_FAILED);
            $responseCode = HttpStatusCodes::EXPECTATION_FAILED;
        }

        return [$responseData, $responseCode];
    }

    /**
     * Retrieve the name of the parcel tracking file in the (local) filesystem
     *
     * @param string $parcelTrackingNumber
     * @return string
     */
    private function getParcelTrackingFilename(string $parcelTrackingNumber): string
    {
        return sprintf('%s/%s.json', self::PARCEL_TRACKING_FILE_DIRECTORY, $parcelTrackingNumber);
    }

    /**
     * Determine, based on several criteria, if the identified parcel tracking file is accessible or not
     *
     * @param string $parcelFile
     * @return bool
     */
    private function isParcelTrackingFileAccessible(string $parcelFile): bool
    {
        return file_exists($parcelFile) && is_readable($parcelFile) && filesize($parcelFile);
    }

    /**
     * Retrieve parcel data from the supplied tracking file
     *
     * The function returns a scalar array, composed of two elements:
     *   - An array of parcel data
     *   - An HTTP status code
     *
     * @param string $parcelFile
     * @return array
     */
    private function getParcelTrackingFileData(string $parcelFile): array
    {
        if ($this->isParcelTrackingFileAccessible($parcelFile)) {
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
}
