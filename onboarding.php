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
            <?php
                $name = isset($_GET['name']) > 0 ? $_GET['name'] : "";
                $surname = isset($_GET['surname']) > 0 ? $_GET['surname'] : "";
                echo "<nav class='d-flex bg-light nav-bar mb-4 rounded-3 justify-content-end'>
                    <a class='btn btn-light btn-link' href='addTask.php?name={$name}&surname={$surname}'>Dodaj novi zadatak</a>&nbsp;
                    <a class='btn btn-light btn-link' href='landingPage.php'>Vrati se na prethodnu stranicu</a>
                    <a class='btn btn-light btn-link' href='logout.php'>Odjava</a>
                </nav>
                <form method='get' class='d-flex flex-column gap-3 text-white' action='onboarding.php'>
                    <label>Ime: <input type='text' class='form-control' name='name' value='{$name}' /></label>
                    <label>Prezime: <input type='text' class='form-control' name='surname' value='{$surname}' /></label>
                    <button type='submit' class='btn btn-light'>Pretraži</button>
                </form>";
                if(count($_GET) > 0){
                    $conn = new mysqli("localhost", "root", "", "test");
                    if($conn->connect_error)
                        die("Connection failed: " . $conn->connect_error);

                    // Verify if the employee exists
                    $result = $conn->query("SELECT employees.ID
                        from employees
                        where employees.name = '{$name}'
                        AND employees.surname = '{$surname}'
                    ");

                    echo "<section class='mt-4 bg-light p-4 rounded-3'>";
                    // If employee exists, retrieve onboarding tasks
                    if($result->num_rows == 1){
                        $employeeID = $result->fetch_assoc()['ID'];
                        $result = $conn->query("SELECT employees.dateOfEmployment, positions.position, departments.department, onboarding.id
                            from employees
                            join positions on employees.positionID = positions.ID
                            join departments on employees.departmentID = departments.ID
                            join onboarding on onboarding.employeeID = employees.ID
                            where employees.id = " . intval($employeeID)
                        );
                        $arr = $result->fetch_assoc();
                        echo "
                            <h1>{$name} {$surname}, zaposlen/a {$arr['dateOfEmployment']}</h1>
                            <h2>{$arr['position']}, odjel {$arr['department']}</h2>
                        ";

                        $taskID = $arr['id'];
                        $taskArray = [$taskID => $arr['dateOfEmployment']];

                        $result = $conn->query("SELECT
                            onboarding.id, onboarding.taskID, onboarding.task, onboarding.description,
                            onboarding.requirements, onboarding.finished, onboarding.dateOffset, employees.dateOfEmployment
                            from onboarding
                            join employees on employees.ID = onboarding.employeeID
                            where onboarding.employeeID = " . intval($employeeID)
                        );
                        // Retrieve and display data
                        if ($result->num_rows > 0){
                            echo "<ul>";
                            while($row = $result->fetch_assoc()) {
                                $taskDueDate = (is_null($row['taskID'])) ?
                                    date('d-m-Y', strtotime($taskArray[$taskID] . " + " . intval($row['dateOffset']) . " days")) :
                                    date('d-m-Y', strtotime($taskArray[$row['taskID']] . " + " . intval($row['dateOffset']) . " days"));

                                $taskArray[$row['id']] = $taskDueDate;
                                echo "
                                    <li><b>Zadatak: {$row["task"]}</b> (datum završetka: <u>{$taskDueDate}</u>)<br/>
                                        {$row["description"]}
                                        <ul>
                                            <li class='small'>Zahtjevi: {$row["requirements"]}</li>
                                            <li class='small'>Status: " . ($row["finished"]
                                                ? "<span class='text-success'>Završen</span>"
                                                : "<span class='text-warning'>U tijeku</span>")
                                                . "</li>
                                        </ul>
                                    </li>
                                ";
                            }
                            echo "</ul>
                                <a class='btn btn-secondary' href='addTask.php?id={$employeeID}'>Uredi onboarding proces</a>
                            ";
                        }
                        else
                            echo "Zaposlenik nema zadataka.<br/>Možete dodati nove zadatke u <a href='addTask.php?id={$employeeID}'>onboarding procesu</a>.";
                    }
                    else echo "Zaposlenik nije pronađen.";
                    mysqli_close($conn);
                    echo "</section>";
                }
            ?>
        </main>
    </body>
</html>