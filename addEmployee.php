
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
            name, surname, dateOfBirth, dateOfEmployment, positionID, departmentID
        ) values (
            '{$_POST['name']}', '{$_POST['surname']}', '{$_POST['dateOfBirth']}',
            '{$_POST['dateOfEmployment']}', '{$_POST['position']}', '{$_POST['department']}'
        )";
        echo "<div class='container mt-4 fixed-top'>";
        if ($conn->query($sql) === TRUE)
            echo "<p class='alert alert-success'>Zaposlenik je dodan.</p><br/>";
        else
            echo "<p class='alert alert-danger'>Error: {$sql}<br>{$conn->error}</p><br/>";
        $conn->close();
        echo "</div>";
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </head>
    <body class="p-5 bg-body align-items-center d-flex width-100">
        <main class="container bg-primary p-5 rounded-3 width-100">
            <nav class="d-flex bg-light nav-bar mb-4 rounded-3 justify-content-end">
                <a class="btn btn-light btn-link" href='landingPage.php'>Vrati se na prethodnu stranicu</a>&nbsp;
                <a class='btn btn-light btn-link' href='logout.php'>Odjava</a>
            </nav>
            <h1 class="text-white font-weight-uppercase">Dodaj novog zaposlenika</h1>
            <form method="POST" action="addEmployee.php" class="d-flex flex-column gap-3 text-white">
                <label for="name">Ime zaposlenika:</label>
                <input class="form-control" type="text" id="name" name="name" required><br/>

                <label for="surname">Prezime zaposlenika:</label>
                <input class="form-control" type="text" id="surname" name="surname" required><br/>

                <label for="dateOfBirth">Datum rođenja:</label>
                <input class="form-control" type="date" id="dateOfBirth" name="dateOfBirth" required><br/>

                <label for="dateOfEmployment">Datum zaposlenja:</label>
                <input class="form-control" type="date" id="dateOfEmployment" name="dateOfEmployment" required><br/>

                <label for="position">Pozicija:</label>
                <select class="form-select" name="position" required>
                    <option value="" disabled selected>Odaberi poziciju</option>
                    <option value="1">Softverski inženjer</option>
                    <option value="2">Regruter</option>
                    <option value="3">Seniorski konzultant u prodaji</option>
                    <option value="4">Pripravnik</option>
                    <option value="5">Sistemski administrator</option>
                    <option value="6">Odvjetnik</option>
                    <option value="7">Promoter društvenih mreža</option>
                </select>

                <label for="department">Odjel:</label>
                <select class="form-select" name="department" required>
                    <option value="" disabled selected>Odaberi odjel</option>
                    <option value="1">Istraživanje i razvoj</option>
                    <option value="2">Prodaja</option>
                    <option value="3">Marketing</option>
                    <option value="4">Zakonska služba</option>
                    <option value="5">Sistemska podrška</option>
                    <option value="6">Nabava</option>
                    <option value="7">Kadrovska služba</option>
                    <option value="8">Uprava</option>
                    <option value="9">Relacije s javnošću</option>
                </select>

                <button type="submit" class="btn btn-outline-light">Dodaj zaposlenika</button>
            </form>
        </main>
        <script>
            // Remove success/error message after 3 seconds
            setTimeout(() => {
                const alertBox = document.querySelector('.container.mt-4.fixed-top');
                if (alertBox) {
                    alertBox.remove();
                }
            }, 3000);
    </body>
</html>