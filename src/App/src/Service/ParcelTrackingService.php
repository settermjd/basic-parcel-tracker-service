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
     * @param int $statusCode
     * @return array
     */
    public function getErrorResponseBody(int $statusCode): array;

    /**
     * @param $pid
     * @return bool
     */
    public function isValidParcelTrackingNumber($pid): bool;

    /**
     * @param string $pid
     * @return array
     */
    public function getParcelData(string $pid): array;
}
