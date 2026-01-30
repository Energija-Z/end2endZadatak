<?php
    session_start();
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

        $sql = "INSERT INTO employees (
            name, surname, dateOfBirth, dateOfEmployment, position, department
        ) values (
            '{$_POST['name']}', '{$_POST['surname']}', '{$_POST['dateOfBirth']}',
            '{$_POST['dateOfEmployment']}', '{$_POST['position']}', '{$_POST['department']}'
        )";

        if ($conn->query($sql) === TRUE)
            echo "<p class='alert alert-success'>Employee added successfully!</p>";
        else
            echo "<p class='alert alert-danger'>Error: {$sql}<br>{$conn->error}</p>";
        $conn->close();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>end2end: add employee</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <a href='landingPage.php'>Return to landing page</a>
        <a href='logout.php'>Logout</a>
        <h1>Add New Employee</h1>
        <form method="POST" action="addEmployee.php">
            <label for="name">Employee Name:</label>
            <input type="text" id="name" name="name" required><br/>

            <label for="surname">Employee Surname:</label>
            <input type="text" id="surname" name="surname" required><br/>

            <label for="dateOfBirth">Date of birth:</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" required><br/>

            <label for="dateOfEmployment">Date of employment:</label>
            <input type="date" id="dateOfEmployment" name="dateOfEmployment" required><br/>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" required><br/>

            <label for="department">Department:</label>
            <select name="department" required>
                <option value="" disabled selected>Select department</option>
                <option value="Sales">Sales</option>
                <option value="Research and development">Research and development</option>
                <option value="Human resources">Human resources</option>
                <option value="Marketing">Marketing</option>
                <option value="Public relations">Public relations</option>
                <option value="Legal">Legal</option>
                <option value="IT">IT</option>
            </select>

            <button type="submit">Add Employee</button>
        </form>
    </body>
</html>