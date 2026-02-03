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
        <title>end2end: početna stranica</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"> 
    </head>
    <body>
        <h1>Dobro došli u end2end.</h1>
        <ul>
            <li><a href='employeeList.php'>Popis zaposlenika</a></li>
            <li><a href='addEmployee.php'>Dodaj zaposlenika</a></li>
        </ul>
        <a href='logout.php'>Odjava</a>
    </body>
</html>