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
        <title>end2end: dodaj zadatak</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <a href='.' onclick="window.history.back()">Vrati se na prethodnu stranicu</a>
        <a href='logout.php'>Odjava</a>
        <h1>Dodaj novi zadatak</h1>
        <form method="POST" action="">

            <button type="submit">Dodaj zadatak</button>
        </form>
    </body>
</html>