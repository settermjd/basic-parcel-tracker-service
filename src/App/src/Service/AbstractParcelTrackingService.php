<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Class AbstractParcelTrackingService
 * @package App\Service
 */
class AbstractParcelTrackingService implements ParcelTrackingServiceValidator
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
    protected const VALID_PARCEL_TRACKING_NUMBER_REGEX = '/TN\d{9}[A-Z]{2}/';

    /**
     * @inheritdoc
     */
    public function isValidParcelTrackingNumber(string $parcelTrackingNumber): bool
    {
        return preg_match(FileParcelTrackingService::VALID_PARCEL_TRACKING_NUMBER_REGEX, $parcelTrackingNumber) === 1;
    }
}
