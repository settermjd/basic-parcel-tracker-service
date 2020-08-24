<?php
declare(strict_types=1);

namespace App\Service;

/**
 * Class FileParcelTrackingService
 * @package App\Service
 */
interface ParcelTrackingService
{
    /**
     * Retrieve an error response body, based on the status code supplied
     *
     * @param int $statusCode
     * @return array
     */
    public function getErrorResponseBody(int $statusCode): array;

    /**
     * Retrieve the parcel data, based on the parcel tracking number (id) supplied
     *
     * @param string $parcelTrackingNumber
     * @return array
     */
    public function getParcelData(string $parcelTrackingNumber): array;
}
