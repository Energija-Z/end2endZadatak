<?php
    session_start();

    // If session started, display welcome message
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){    
        header('Location: index.html');
        exit;
    }
    // Process form submission
    if(count($_POST) > 0){
        //Connect to the database
        $conn = new mysqli("localhost", "root", "", "test");
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);

        $sql = "INSERT INTO onboarding (
            employeeID, task, description, requirements, finished, dateOffset, taskID
        ) values (
            '{$_GET['id']}', '{$_POST['task_new']}', '{$_POST['description_new']}',
            '{$_POST['requirements_new']}', 0, {$_POST['dateOffset_new']}, {$_POST['taskID_new']}
        )";

        if ($conn->query($sql) === TRUE)
            echo "<p class='alert alert-success'>Zadatak je dodan!</p>";
        else
            echo "<p class='alert alert-danger'>Greška: {$sql}<br>{$conn->error}</p>";
        $conn->close();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>end2end: dodaj zadatak</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <a href='.' onclick="window.history.back()">Vrati se na prethodnu stranicu</a>
        <a href='logout.php'>Odjava</a>
        <h1>Dodaj novi zadatak</h1>
        <form method="post" action="addTask.php?id=<?php echo $_GET['id']; ?>">
            <?php
            $employeeID = $_GET['id'];
            echo "<table>";

            $conn = new mysqli("localhost", "root", "", "test");
            if($conn->connect_error)
                die("Connection failed: " . $conn->connect_error);

            // Verify if the employee exists
            $result = $conn->query("SELECT employees.dateOfEmployment
                from employees
                where employees.id = {$employeeID}
            ");

            // If employee exists, retrieve onboarding tasks
            if($result->num_rows == 1){
                $dateEmployment = $result->fetch_assoc()['dateOfEmployment'];
                $result = $conn->query("SELECT onboarding.id, onboarding.taskID,
                    onboarding.task, onboarding.description, onboarding.requirements, onboarding.finished, onboarding.dateOffset
                    from onboarding
                    join employees on employees.ID = onboarding.employeeID
                    where employees.id = {$employeeID}
                ");
                $arr = $result->fetch_assoc();

                $taskID = $arr['id'];
                $taskArray = [$taskID => $dateEmployment];

                $result = $conn->query("SELECT
                    onboarding.id, onboarding.taskID, onboarding.task, onboarding.description,
                    onboarding.requirements, onboarding.finished, onboarding.dateOffset, employees.dateOfEmployment
                    from onboarding
                    join employees on employees.ID = onboarding.employeeID
                    where onboarding.employeeID = " . intval($employeeID)
                );
                echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Zadatak</th>
                            <th>Opis</th>
                            <th>Zahtjevi</th>
                            <th>Status</th>
                            <th>Ovisi o zadatku na ID-u</th>
                            <th>Datum offseta (dana od zaposlenja)</th>
                            <th>Spremi redak</th>
                        </tr>
                    </thead>
                    <tbody>
                ";
                // Retrieve and display data
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $taskDueDate = (is_null($row['taskID'])) ?
                            date('d-m-Y', strtotime($taskArray[$taskID] . " + " . intval($row['dateOffset']) . " days")) :
                            date('d-m-Y', strtotime($taskArray[$row['taskID']] . " + " . intval($row['dateOffset']) . " days"));

                        $taskArray[$row['id']] = $taskDueDate;
                        echo "
                            <tr>
                                <td>
                                    {$row["id"]} <input type='hidden' name='id_{$row['id']}' value='{$row["id"]}'>
                                </td>
                                <td>
                                    <input type='text' name='task_{$row['id']}' value='{$row["task"]}'>
                                </td>
                                <td>
                                    <textarea type='text' name='description_{$row['id']}'>{$row["description"]}</textarea>
                                </td>
                                <td>
                                    <input type='text' name='requirements_{$row['id']}' value='{$row["requirements"]}'>
                                </td>
                                <td>
                                    <input type='checkbox' name='finished_{$row['id']}' value='1'" . ($row["finished"] ? " checked" : "") . ">
                                </td>
                                <td>
                                    <input type='number' name='taskID_{$row['id']}' value='" . (is_null($row['taskID']) ? "" : $row['taskID']) . "'>
                                </td>
                                <td>
                                    <input type='number' name='dateOffset_{$row['id']}' value='{$row["dateOffset"]}'/> dana (do: {$taskDueDate})
                                </td>
                                <td>
                                    <input type='submit' formaction='saveTask.php?id={$employeeID}&taskID={$row['id']}' value='Spremi'/>
                                </td>
                            </tr>
                        ";
                    }
                }
                echo "</tbody>
                    </table>
                    <button>Dodaj zadatak</button>
                ";
                if($result->num_rows == 0)
                    echo "Zaposlenik nema zadataka.<br/>Možete dodati nove zadatke u <a href='addTask.php?id={$employeeID}'>onboarding procesu</a>.";

                echo "<input type='submit' value='Spremi' disabled/>";
            }
            else echo "Zaposlenik nije pronađen.";
            mysqli_close($conn);
        ?>
        </form>
        <script>
        document.querySelector("button").addEventListener("click", function(event){
            event.preventDefault();
            const row = document.createElement("tr");
            let cell = document.createElement("td");
            cell.innerText = "N/A (automatski dodijeljeno)";
            row.appendChild(cell);

            cell = document.createElement("td");
            let input = document.createElement("input");
            input.type = "text";
            input.name = "task_new";
            cell.appendChild(input);
            row.appendChild(cell);

            cell = document.createElement("td");
            input = document.createElement("textarea");
            input.name = "description_new";
            cell.appendChild(input);
            row.appendChild(cell);

            cell = document.createElement("td");
            input = document.createElement("input");
            input.type = "text";
            input.name = "requirements_new";
            cell.appendChild(input);
            row.appendChild(cell);

            cell = document.createElement("td");
            input = document.createElement("input");
            input.type = "checkbox";
            input.name = "finished_new";
            input.value = "1";
            cell.appendChild(input);
            row.appendChild(cell);

            cell = document.createElement("td");
            input = document.createElement("input");
            input.type = "number";
            input.name = "taskID_new";
            cell.appendChild(input);
            row.appendChild(cell);

            cell = document.createElement("td");
            input = document.createElement("input");
            input.type = "number";
            input.name = "dateOffset_new";
            cell.appendChild(input);
            row.appendChild(cell);

            const tbody = document.createElement("tbody");
            tbody.appendChild(row);

            document.querySelector("table tbody").parentNode.replaceChild(tbody, document.querySelector("table tbody"));
            document.querySelector("input[type='submit']").disabled = false;
            document.querySelector("button").disabled = true;
        });
        </script>
    </body>
</html>