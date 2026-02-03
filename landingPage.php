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
        <link rel="stylesheet" href="styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </head>
    <body class="bg-body p-5 align-items-center d-flex width-100" style="height: 85vh;">
        <div class="bg-primary p-4 rounded text-center text-white mx-auto" style="max-width: 400px;">
            <a href='logout.php' class='btn btn-outline-light'>Odjava</a>
            <h1>Dobro došli u end2end.</h1>
            <span>Odaberite jednu od opcija ispod za nastavak:</span><br/>
            <nav class="navbar navbar-expand-lg bg-light mt-3 rounded">
                <ul class="list-unstyled p-3 rounded navbar-collapse">
                    <li class='btn-primary'><a class="btn-link col" href='employeeList.php'>Popis zaposlenika</a></li>
                    <li class='btn-primary'><a class="btn-link col" href='addEmployee.php'>Dodaj zaposlenika</a></li>
                    <li class='btn-primary'><a class="btn-link col" href='onboarding.php'>Pregled onboarding procesa</a></li>
                </ul>
            </nav>
        </div>
    </body>
</html>