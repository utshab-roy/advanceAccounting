<?php
session_start();
include 'config.php';
include 'functions.php';

//if the user is unable to login then redirect to the login page
if (!$_SESSION['logged_in']) {
    header("location:index.php");
    die();
}

//showing the session message if exists
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css"
          integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous"/>

    <title>Journal</title>
</head>
<body>
    <div class="container">

        <nav>
            <div class="row mb-5">
                <a type="button" href="main.php" class="btn btn-primary mr-2">In Voice</a>
                <a type="button" href="journal.php" class="btn btn-secondary mr-2">Journal</a>
                <a type="button" href="inventory.php" class="btn btn-success mr-2">Inventory</a>
                <button type="button" class="btn btn-warning mr-2">Data Analysis</button>

                <button type="button" class="btn btn-danger dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                    Report
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                    <a class="dropdown-item" href="#">In Voice</a>
                    <a class="dropdown-item" href="#">Balance Sheet</a>
                    <a class="dropdown-item" href="#">Income Statement</a>
                    <a class="dropdown-item" href="inventory_report.php">Inventory</a>
                </div>
            </div>
        </nav>

        <h1>Journal</h1>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">date</th>
                <th scope="col">Description</th>
                <th scope="col">Ref.</th>
                <th scope="col">Account</th>
                <th scope="col">Debit</th>
                <th scope="col">Credit</th>
            </tr>
            </thead>
            <tbody>
            <?php
            global $conn_oop;
            $sql = "SELECT * FROM journal";
            $result = $conn_oop->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    //converting the date into proper format
                    $timestamp = strtotime($row["date"]);
                    //first row
                    echo '<tr>';
                    echo '<th scope="row">' . date("m-d-Y", $timestamp) . '</th>';
                    echo '<td scope="row">' . $row["journal"] . '</td>';
                    echo '<td scope="row">' . $row["reference"] . '</td>';
                    echo '<td scope="row">' . $row["account"] . '</td>';
                    echo '<td scope="row">' . $row["debit"] . '</td>';
                    echo '<td scope="row"></td>';
                    echo '</tr>';

                    //second row
                    echo '<tr>';
                    echo '<th scope="row"></th>';
                    echo '<td scope="row">' . $row["journal"] . '</td>';
                    echo '<td scope="row">' . $row["reference"] . '</td>';
                    echo '<td scope="row"></td>';
                    echo '<td scope="row"></td>';
                    echo '<td scope="row">' . $row["credit"] . '</td>';
                    echo '</tr>';

                    //third row
                    //second row
                    echo '<tr>';
                    echo '<th scope="row"></th>';
                    echo '<td scope="row"></td>';
                    echo '<td scope="row"></td>';
                    echo '<td scope="row"></td>';
                    echo '<td scope="row"></td>';
                    echo '<td scope="row"></td>';
                    echo '</tr>';
                }
            } else {
                echo "0 row found in the results";
            }
            $conn_oop->close();
            ?>

            </tbody>
        </table>

    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!--    <script src="js/main.js"></script>-->
</body>
</html>
