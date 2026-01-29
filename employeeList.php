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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <a href='landingPage.php'>Return to landing page</a>
        <a href='logout.php'>Logout</a>

        <?php
            echo "
                <input type='text' placeholder='Filter table'/>
                <table>
                    <tr>
                        <th>Employee ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of birth</th>
                        <th>Date of employement</th>
                        <th>Role</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>John</td>
                        <td>Doe</td>
                        <td>1990-01-01</td>
                        <td>2020-01-01</td>
                        <td>Developer</td>
                        <td>Research & Development</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane</td>
                        <td>Smith</td>
                        <td>1985-05-15</td>
                        <td>2018-03-20</td>
                        <td>Designer</td>
                        <td>Human Resources</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Mike</td>
                        <td>Johnson</td>
                        <td>1978-11-30</td>
                        <td>2015-07-10</td>
                        <td>Manager</td>
                        <td>Marketing</td>
                    </tr>
                </table>
                <br/>
            ";
        ?>

        <a href='index.html'>Logout</a>
        <script>
            document.querySelector('input').addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('table tr:not(:first-child)');
                rows.forEach($row => {
                    const cells = $row.querySelectorAll('td');
                    const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().trim().includes(filter));
                    row.style.display = match ? '' : 'none';
                });
            });
        </script>
    </body>
</html>