<?php
declare(strict_types=1);


/**
 * Class Employee
 */
class Employee
{
    /**
     * @var int
     */
    public $empID;

    /**
     * @var int
     */
    public $projectID;

    /**
     * @var DateTime|string
     */
    public $dateFrom;

    /**
     * @var DateTime|string
     */
    public $dateTo;

    /**
     * Employee constructor.
     * @param int $empID
     * @param int $projectID
     * @param DateTime $dateFrom
     * @param DateTime $dateTo
     */
    public function __construct(int $empID, int $projectID, DateTime $dateFrom, DateTime $dateTo)
    {
        $this->empID = (int)$empID;
        $this->projectID = (int)$projectID;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo ?? new DateTime();
    }
}