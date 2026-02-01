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
    </head>
    <body>
        <a href='.' onclick="window.history.back()">Vrati se na prethodnu stranicu</a>
        <a href='addTask.php?id=<?php echo $_GET['id']; ?>'>Dodaj novi zadatak</a>
        <a href='logout.php'>Odjava</a>
            <?php
                $conn = new mysqli("localhost", "root", "", "test");
                if($conn->connect_error)
                    die("Connection failed: " . $conn->connect_error);

                $result = $conn->query("SELECT
                    employees.name, employees.surname, employees.dateOfEmployment,
                    positions.position, departments.department, onboarding.id
                    FROM employees
                    JOIN positions ON employees.positionID = positions.ID
                    JOIN departments ON employees.departmentID = departments.ID
                    join onboarding on onboarding.employeeID = employees.ID
                    where employees.ID = " . intval($_GET['id'])
                );
                if($result->num_rows >= 1){
                    $arr = $result->fetch_assoc();
                    echo "
                        <h1>{$arr['name']} {$arr['surname']}, zaposlena {$arr['dateOfEmployment']}</h1>
                        <h2>{$arr['position']}, department {$arr['department']}</h2>
                    ";

                    $taskID = $arr['id'];
                    $taskArray = [$taskID => $arr['dateOfEmployment']];

                    $result = $conn->query("SELECT
                        onboarding.id, onboarding.taskID, onboarding.task, onboarding.description,
                        onboarding.requirements, onboarding.finished, onboarding.dateOffset, employees.dateOfEmployment
                        from onboarding
                        join employees on employees.ID = onboarding.employeeID
                        where onboarding.employeeID = " . intval($_GET['id'])
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
                        echo "</ul>";
                    }
                    else
                        echo "Zaposlenik nema zadataka.<br/>Možete dodati nove zadatke u <a href='addTask.php?id={$_GET['id']}'>onboarding procesu</a>.";
                }
                else
                    echo "Zaposlenik sa zadatkom nije pronađen.";
                mysqli_close($conn);
            ?>
        </table>
    </body>
</html>