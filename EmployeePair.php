<?php
declare(strict_types=1);

/**
 * Class EmployeePair
 */
class EmployeePair
{
    /**
     * @var array
     */
    private $employeeRecords = [];

    /**
     * @param Employee $employee
     */
    public function addEmployeeRecord(Employee $employee)
    {
        $this->employeeRecords[] = $employee;
    }

    /**
     * @return array
     */
    public function findCommonProjects(): array
    {
        $results = [];

        foreach ($this->employeeRecords as $i => $employeeFirst) {
            for ($j = $i + 1; $j < count($this->employeeRecords); $j++) {
                $employeeSecond = $this->employeeRecords[$j];

                if ($employeeFirst->projectID === $employeeSecond->projectID) {
                    $daysWorked = $this->calculateDaysWorked($employeeFirst, $employeeSecond);

                    if ($daysWorked > 0) {
                        $results[] = [
                            'employeeFirst' => $employeeFirst->empID,
                            'employeeSecond' => $employeeSecond->empID,
                            'projectID' => $employeeFirst->projectID,
                            'daysWorked' => $daysWorked,
                        ];
                    }
                }
            }
        }

        return $results;
    }

    /**
     * @param Employee $employeeFirst
     * @param Employee $employeeSecond
     * @return int
     */
    private function calculateDaysWorked(Employee $employeeFirst, Employee $employeeSecond): int
    {
        $startDate = max($employeeFirst->dateFrom, $employeeSecond->dateFrom);
        $endDate = min($employeeFirst->dateTo, $employeeSecond->dateTo);

        return $startDate <= $endDate ? $startDate->diff($endDate)->days : 0;
    }
}