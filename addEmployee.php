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
        <title>end2end: add employee</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <a href='landingPage.php'>Return to landing page</a>
        <a href='logout.php'>Logout</a>
        <h1>Add New Employee</h1>
        <form>
            <label for="name">Employee Name:</label>
            <input type="text" id="name" name="name" required><br/>

            <label for="surname">Employee Surname:</label>
            <input type="text" id="surname" name="surname" required><br/>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" required><br/>

            <label for="dateOfBirth">Date of birth:</label>
            <input type="text" id="dateOfBirth" name="dateOfBirth" required><br/>

            <label for="dateOfEmployment">Date of employment:</label>
            <input type="text" id="dateOfEmployment" name="dateOfEmployment" required><br/>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" required><br/>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required><br/>

            <button type="submit">Add Employee</button>
        </form>
    </body>
</html>