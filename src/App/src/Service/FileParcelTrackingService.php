<?php
declare(strict_types=1);

namespace App\Service;

use Mezzio\Exception\InvalidArgumentException;

/**
 * Class ParcelTrackingService
 * @package App\Service
 */
class FileParcelTrackingService implements ParcelTrackingService
{
    private const DATA_FILE_DIR = __DIR__ . '/../../../../data/';

    /** @var string */
    private string $parcelTrackingDataFileDirectory;

    public function __construct()
    {
        $this->parcelTrackingDataFileDirectory = self::DATA_FILE_DIR . 'parcel_tracking_files';
    }

    /**
     * @param string $parcelTrackingFile
     * @return mixed
     */
    public function getParcelData(string $parcelTrackingFile)
    {
        return json_decode(file_get_contents($parcelTrackingFile));
    }

    /**
     * @param string $parcelTrackingNumber
     * @return string
     * @throws InvalidArgumentException
     */
    public function getTrackingFile(string $parcelTrackingNumber): string
    {
        $parcelTrackingFile = sprintf(
            '%s/%s.json',
            $this->parcelTrackingDataFileDirectory,
            $parcelTrackingNumber
        );

        if (!file_exists($parcelTrackingFile) || !is_readable($parcelTrackingFile)) {
            throw new InvalidArgumentException('Parcel tracking file does not exist');
        }

        return $parcelTrackingFile;
    }

    /**
     * @param string $parcelTrackingFile
     * @return bool
     */
    public function hasTrackingFile(string $parcelTrackingFile): bool
    {
        return file_exists($parcelTrackingFile);
    }
}
