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
        <link rel="stylesheet" href="styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </head>
    <body class="p-5 bg-body align-items-center d-flex width-100">
        <main class="container bg-primary p-5 rounded-3 width-100">
            <nav class="d-flex bg-light nav-bar mb-4 rounded-3 justify-content-end">
                <a class="btn btn-light btn-link" href='landingPage.php'>Vrati se na prethodnu stranicu</a>&nbsp;
                <a class='btn btn-light btn-link' href='logout.php'>Odjava</a>
            </nav>
            <h2 class="text-white font-weight-uppercase">Popis zaposlenika</h2>
            <input class="form-control mb-3" type="text" placeholder="Pretraži zaposlenike...">
            <table class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr class="table-dark">
                        <th>Ime i prezime</th>
                        <th>Datum rođenja</th>
                        <th>Datum zaposlenja</th>
                        <th>Uloga</th>
                        <th>Odjel</th>
                        <th>Zadaci</th>
                    </tr>
                </thead>
                
                <?php
                    echo "<tbody>";

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
                        .(isset($_GET['limit']) && is_numeric($_GET['limit']) ? ", " . intval($_GET['limit']) * 10 : "")
                    );

                    // Retrieve and display data
                    $countCurrentPage = $result->num_rows;
                    if ($countCurrentPage > 0)
                        while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row["name"]} {$row["surname"]}</td>
                                <td>" . date('d. m. Y.', strtotime($row["dateOfBirth"])). "</td>
                                <td>" . date('d. m. Y.', strtotime($row["dateOfEmployment"])). "</td>
                                <td>" . $row["position"]. "</td>
                                <td>" . $row["department"]. "</td>
                                <td><a class='btn btn-secondary' href='onboarding.php?name={$row["name"]}&surname={$row["surname"]}'>Zadaci</a></td>
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
                        echo "<a href='employeeList.php?limit=" . ($limit + 1) . "' class='btn btn-primary'>Vidi više</a>&nbsp;";

                    if($limit > 1)
                        echo "<a href='employeeList.php?limit=" . ($limit - 1) . "' class='btn btn-primary'>Vidi manje</a>";
                    else if($limit > 0)
                        echo "<a href='employeeList.php' class='btn btn-primary'>Vidi manje</a>";

                    mysqli_close($conn);
                    echo "
                            </th>
                        </tr>
                    </tfoot>";
                ?>
            </table>
        </main>
        <script>
            document.querySelector('input').addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('table tbody tr');
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
                    
                    rows.forEach(row => document.querySelector("table tbody").appendChild(row));
                    
                    table.querySelectorAll('th').forEach(th => th.classList.remove('asc', 'desc'));
                    this.classList.add(asc ? 'asc' : 'desc');
                });
            });
        </script>
    </body>
</html>