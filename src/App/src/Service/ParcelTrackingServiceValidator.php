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
     * @param $pid
     * @return bool
     */
    public function isValidParcelTrackingNumber($pid): bool;
}
