<?php
require_once 'Employee.php';
require_once 'EmployeePair.php';
require_once 'CSVReader.php';
require_once 'DateParser.php';

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csvFile'])) {
    try {
        $fileName = $_FILES['csvFile']['name'];
        $filePath = $_FILES['csvFile']['tmp_name'];
        $dateParser = new DateParser();
        $csvReader = new CSVReader($fileName, $filePath, $dateParser);
        $employees = $csvReader->parseFile();

        $employeePair = new EmployeePair();

        foreach ($employees as $employee) {
            $employeePair->addEmployeeRecord($employee);
        }

        $results = $employeePair->findCommonProjects();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Pair of employees who have worked together</title>
    </head>
    <body>
        <h1>Pair of employees who have worked together</h1>

        <form method="post" enctype="multipart/form-data">
            <label for="csvFile">Upload CSV File:</label>
            <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
            <button type="submit">Calculate</button>
        </form>

        <?php if (!empty($error)) { ?>
            <p style="color: red;">Error: <?php echo $error; ?></p>
        <?php } ?>

        <?php if (!empty($results)) { ?>
            <h2>Results</h2>
            <table border="1">
                <thead>
                <tr>
                    <th>Employee ID #1</th>
                    <th>Employee ID #2</th>
                    <th>Project ID</th>
                    <th>Days Worked</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $row) { ?>
                    <tr>
                        <td><?php echo $row['employeeFirst']; ?></td>
                        <td><?php echo $row['employeeSecond']; ?></td>
                        <td><?php echo $row['projectID']; ?></td>
                        <td><?php echo $row['daysWorked']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </body>
</html>