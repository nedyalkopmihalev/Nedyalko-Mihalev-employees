<?php
declare(strict_types=1);

require_once 'DateParser.php';
require_once 'Employee.php';

/**
 * Class CSVReader
 */
class CSVReader
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var DateParser
     */
    private $dateParser;

    /**
     * CSVReader constructor.
     * @param string $fileName
     * @param string $filePath
     * @param DateParser $dateParser
     */
    public function __construct(string $fileName, string $filePath, DateParser $dateParser)
    {
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->dateParser = $dateParser;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function parseFile(): array
    {
        $employees = [];

        if (!file_exists($this->filePath)) {
            throw new Exception("File not found: " . $this->filePath);
        }

        if (!$this->checkFileExtension()) {
            throw new Exception("Invalid file type!");
        }

        if (($handle = fopen($this->filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                list($empID, $projectID, $dateFrom, $dateTo) = $data;

                $empID = (int) $empID;
                $projectID = (int) $projectID;
                $dateFromParsed = $this->dateParser->parseDate($dateFrom);
                $dateToParsed = $this->dateParser->parseDate($dateTo);

                $employees[] = new Employee($empID, $projectID, $dateFromParsed, $dateToParsed);
            }

            fclose($handle);
        }

        return $employees;
    }

    /**
     * @return bool
     */
    private function checkFileExtension()
    {
        $fileExtension = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));

        if ($fileExtension !== 'csv') {
            return false;
        }

        return true;
    }
}