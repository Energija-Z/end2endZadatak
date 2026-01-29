<?php
session_start();
// If credentials are correct, start session
if(isset($_SESSION['loggedin']) || ($_POST['username'] === "root" && $_POST['password'] === "root"))
    $_SESSION['loggedin'] = true;

// If session started, display welcome message
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){    
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>end2end: landing page</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <h1>Welcome to end2endTask.</h1>
        <ul>
            <li><a href='employeeList.php'>Employee list</a></li>
            <li><a href='addEmployee.php'>Add employee</a></li>
        </ul>
        <a href='logout.php'>Logout</a>
    </body>
</html>