<?php

namespace App\Service;

/**
 * Class FileParcelTrackingService
 * @package App\Service
 */
interface ParcelTrackingServiceValidator
{
    /**
     * Determines if the parcel tracking number supplied is a valid one or not
     *
     * @param string $parcelTrackingNumber
     * @return bool
     */
    public function isValidParcelTrackingNumber(string $parcelTrackingNumber): bool;
}
