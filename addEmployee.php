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
        <title>end2end: dodaj zaposlenika</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <a href='.' onclick="window.history.back()">Vrati se na prethodnu stranicu</a>
        <a href='logout.php'>Odjava</a>
        <h1>Dodaj novog zaposlenika</h1>
        <form method="POST" action="addEmployee.php">
            <label for="name">Ime zaposlenika:</label>
            <input type="text" id="name" name="name" required><br/>

            <label for="surname">Prezime zaposlenika:</label>
            <input type="text" id="surname" name="surname" required><br/>

            <label for="dateOfBirth">Datum rođenja:</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" required><br/>

            <label for="dateOfEmployment">Datum zaposlenja:</label>
            <input type="date" id="dateOfEmployment" name="dateOfEmployment" required><br/>

            <label for="position">Pozicija:</label>
            <input type="text" id="position" name="position" required><br/>

            <label for="department">Odjel:</label>
            <select name="department" required>
                <option value="" disabled selected>Odaberi odjel</option>
                <option value="Prodaja">Prodaja</option>
                <option value="Istraživanje i razvoj">Istraživanje i razvoj</option>
                <option value="Kadrovska služba">Kadrovska služba</option>
                <option value="Marketing">Marketing</option>
                <option value="Uprava">Uprava</option>
                <option value="Relacije s javnošću">Relacije s javnošću</option>
                <option value="Zakonska služba">Zakonska služba</option>
                <option value="Sistemska podrška">Sistemska podrška</option>
            </select>

            <button type="submit">Dodaj zaposlenika</button>
        </form>
    </body>
</html>