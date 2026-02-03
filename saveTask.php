<?php
    session_start();

    // If session started, display welcome message
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
        <link rel="stylesheet" href="styles.css">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    </head>
    <body>
        <?php
            // Process form submission
            if(count($_POST) > 0){
                //Connect to the database
                $conn = new mysqli("localhost", "root", "", "test");
                if ($conn->connect_error)
                    die("Connection failed: " . $conn->connect_error);
                $taskID = $_GET['taskID'];
                $sql = "UPDATE onboarding SET
                    task = '{$_POST['task_'.$taskID]}',
                    description = '{$_POST['description_'.$taskID]}',
                    requirements = '{$_POST['requirements_'.$taskID]}',
                    finished = " . (isset($_POST['finished_'.$taskID]) ? 1 : 0) . ",
                    dateOffset = {$_POST['dateOffset_'.$taskID]},
                    taskID = " . (is_numeric($_POST['taskID_'.$taskID]) ? $_POST['taskID_'.$taskID] : "NULL") . "
                    WHERE id = {$taskID} AND employeeID = {$_GET['id']}
                ";
                if($conn->query($sql) === TRUE)
                    echo "<p class='alert alert-success'>Zadatak je upisan.</p>";
                else
                    echo "<p class='alert alert-danger'>Error: {$sql}<br/>{$conn->error}</p>";
                $conn->close();
                header("refresh:4;url=addTask.php?id={$_GET['id']}");
            }
        ?>
    </body>
</html>