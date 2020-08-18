<?php
declare(strict_types=1);

namespace App\Service;

use Mezzio\Exception\InvalidArgumentException;

/**
 * Class ParcelTrackingService
 * @package App\Service
 */
interface ParcelTrackingService
{
    /**
     * @param string $parcelTrackingFile
     * @return mixed
     */
    public function getParcelData(string $parcelTrackingFile);

    /**
     * @param string $parcelTrackingNumber
     * @return string
     * @throws InvalidArgumentException
     */
    public function getTrackingFile(string $parcelTrackingNumber): string;

    /**
     * @param string $parcelTrackingFile
     * @return bool
     */
    public function hasTrackingFile(string $parcelTrackingFile): bool;
}
