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
        <title>end2end: Employee list</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <a href='landingPage.php'>Return to landing page</a>
        <a href='logout.php'>Logout</a>
            <?php
                $conn = new mysqli("localhost", "root", "", "test");
                if($conn->connect_error)
                    die("Connection failed: " . $conn->connect_error);

                $result = $conn->query("SELECT
                    onboarding.task, onboarding.requirements, onboarding.dueDate
                    from onboarding
                    join employees on employees.ID = onboarding.employeeID
                    where onboarding.employeeID = " . intval($_GET['id'])
                );
                // Retrieve and display data
                if ($result->num_rows > 0)
                    while($row = $result->fetch_assoc()) {
                        echo "<ul>
                            <li>{$row["task"]}</li>
                            <li>{$row["requirements"]}</li>
                            <li>{$row["dueDate"]}</li>
                        </ul>";
                    }
                else
                    echo "0 results";

                mysqli_close($conn); 
            ?>
        </table>
    </body>
</html>