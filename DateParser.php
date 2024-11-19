<?php
declare(strict_types=1);

/**
 * Class DateParser
 */
class DateParser
{
    /**
     * @var array
     */
    private $supportedFormats = [
        'Y-m-d',
        'd/m/Y',
        'm/d/Y',
        'd-m-Y',
    ];

    /**
     * @param string $date
     * @return DateTime
     * @throws Exception
     */
    public function parseDate(string $date): DateTime
    {
        if (strtoupper($date) === 'NULL' || empty($date)) {
            return new DateTime();
        }

        foreach ($this->supportedFormats as $format) {
            $parsedDate = DateTime::createFromFormat($format, $date);

            if ($parsedDate !== false) {
                return $parsedDate;
            }
        }

        throw new Exception("Unsupported date format: $date");
    }
}