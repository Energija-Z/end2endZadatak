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
        <title>end2end: popis zaposlenika</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"> 
    </head>
    <body>
        <a href='.' onclick="window.history.back()">Vrati se na prethodnu stranicu</a>
        <a href='logout.php'>Odjava</a>
        <table>
            <thead>
                <h2>Popis zaposlenika</h2>
                <input type="text" placeholder="Pretraži zaposlenike...">
            </thead>
            
            <?php
                echo "<tbody>
                    <tr>
                        <th>Ime i prezime</th>
                        <th>Datum rođenja</th>
                        <th>Datum zaposlenja</th>
                        <th>Uloga</th>
                        <th>Odjel</th>
                        <th>Zadaci</th>
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
                            <td><a href='onboarding.php?name={$row["name"]}&surname={$row["surname"]}'>View</a></td>
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
            document.querySelectorAll('th').forEach(th => {
                th.addEventListener('click', function() {
                    const table = this.closest('table');
                    const rows = Array.from(table.querySelectorAll('tr:nth-child(n+2)'));
                    const index = Array.from(this.parentNode.children).indexOf(this);
                    const asc = !this.classList.contains('asc');
                        
                    rows.sort((a, b) => {
                        const cellA = a.children[index].textContent.trim().toLowerCase();
                        const cellB = b.children[index].textContent.trim().toLowerCase();
                        return asc ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                    });
                    
                    rows.forEach(row => table.appendChild(row));
                    
                    table.querySelectorAll('th').forEach(th => th.classList.remove('asc', 'desc'));
                    this.classList.add(asc ? 'asc' : 'desc');
                });
            });

        </script>
    </body>
</html>