<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>end2end: Employee list</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <a href='landingPage.php'>Return to landing page</a>
        <a href='logout.php'>Logout</a>
        <table>
            <thead>
                <h2>Employee list</h2>
                <input type="text" placeholder="Search employees...">
            </thead>
            
            <?php
                echo "<tbody>
                    <tr>
                        <th>Full name</th>
                        <th>Date of Birth</th>
                        <th>Date of Employment</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Onboarding</th>
                    </tr>
                ";

                //Connect to the database
                $conn = new mysqli("localhost", "root", "", "test");
                if($conn->connect_error)
                    die("Connection failed: " . $conn->connect_error);

                $result = $conn->query("SELECT
                    employees.ID, employees.name, employees.surname, employees.dateOfBirth, employees.dateOfEmployment,
                    positions.position, departments.department
                    FROM employees
                    JOIN positions ON employees.positionID = positions.ID
                    JOIN departments ON employees.departmentID = departments.ID
                    Order BY employees.surname, employees.name
                    limit 10"
                    .(isset($_GET['limit']) && is_numeric($_GET['limit']) ? ", ".$_GET['limit'] : "")
                );

                // Retrieve and display data
                $countCurrentPage = $result->num_rows;
                if ($countCurrentPage > 0)
                    while($row = $result->fetch_assoc()) {
                       echo "<tr>
                            <td>{$row["name"]} {$row["surname"]}</td>
                            <td>" . $row["dateOfBirth"]. "</td>
                            <td>" . $row["dateOfEmployment"]. "</td>
                            <td>" . $row["position"]. "</td>
                            <td>" . $row["department"]. "</td>
                            <td><a href='onboarding.php?id={$row["ID"]}'>View</a></td>
                        </tr>";
                    }
                else
                    echo "0 results";

                echo "</tbody>
                    <tfoot>
                        <tr>
                            <th colspan='6'>
                ";
                $countTotal = $conn->query("SELECT COUNT(*) as total FROM employees")->fetch_assoc()['total'];
                $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 0;

                if($countTotal > 10 * ($limit + 1))
                    echo "<a href='employeeList.php?limit=" . ($limit + 1) . "'>View More</a>&nbsp;";

                if($limit > 1)
                    echo "<a href='employeeList.php?limit=" . ($limit - 1) . "'>View Less</a>";
                else if($limit > 0)
                    echo "<a href='employeeList.php'>View Less</a>";

                mysqli_close($conn);
                echo "
                        </th>
                    </tr>
                </tfoot>";
            ?>
        </table>
        <script>
            document.querySelector('input').addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('table tr:not(:first-child)');
                rows.forEach($row => {
                    const cells = $row.querySelectorAll('td');
                    const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().trim().includes(filter));
                    $row.style.display = match ? '' : 'none';
                });
            });
        </script>
    </body>
</html>