<?php
declare(strict_types=1);

namespace App\Service;

use Teapot\StatusCode\RFC\RFC7231 as HttpStatusCodes;

/**
 * Class FileParcelTrackingService
 * @package App\Service
 */
class FileParcelTrackingService
{
    public const DIR = __DIR__ . '/../../../../data/results';

    /**
     * Regex to determine a valid parcel id
     *
     * A valid parcel id must follow the format:
     *     TN + 9 digits + 2 character country code (ISO 3166-1 alpha-2)
     * An example code matching that format is: TN100036127AU
     *
     * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
     */
    public const VALID_PARCEL_ID = '/TN\d{9}[A-Z]{2}/';

    /**
     * @param string $parcelFile
     * @return string
     */
    public function getParcelData(string $parcelFile): string
    {
        return json_decode(file_get_contents($parcelFile));
    }

    /**
     * @param int $statusCode
     * @return array
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
     * @param $pid
     * @return bool
     */
    public function isValidParcelTrackingNumber($pid): bool
    {
        return preg_match(self::VALID_PARCEL_ID, $pid);
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
     * @param string $dir
     * @return array
     */
    public function getParcelTrackingData(string $pid, string $dir): array
    {
        if ($this->isValidParcelTrackingNumber($pid)) {
            $parcelFile = sprintf('%s/%s.json', $dir, $pid);
            list($responseData, $responseCode) = $this->getParcelTrackingFileData($parcelFile, $dir);
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
            $responseData = $this->getParcelData($dir);
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
