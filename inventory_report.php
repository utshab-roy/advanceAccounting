<?php
session_start();
include 'config.php';
include 'functions.php';

//if the user is unable to login then redirect to the login page
if (!$_SESSION['logged_in']) {
    header("location:index.php");
    die();
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

    <title>Inventory Report</title>
</head>
<body>
<div class="container">

    <nav>
        <div class="row mb-5">
            <button type="button" class="btn btn-primary mr-2">In Voice</button>
            <button type="button" class="btn btn-secondary mr-2">Journal</button>
            <a type="button" href="inventory.php" class="btn btn-success mr-2">Inventory</a>
            <button type="button" class="btn btn-warning mr-2">Data Analysis</button>

            <button type="button" class="btn btn-danger dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" data-offset="10,20">
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

    <h1>Inventory Report</h1>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Date & Time</th>
            <th scope="col">Product_id</th>
            <th scope="col">Quantity</th>
            <th scope="col">Item</th>
            <th scope="col">Unit_price</th>
            <th scope="col">Tax</th>
            <th scope="col">Discount</th>
            <th scope="col">Total</th>
        </tr>
        </thead>
        <tbody>
        <?php
        global $conn_oop;
        $sql = "SELECT * FROM inventory_report";
        $result = $conn_oop->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<th scope="row">' . $row["date"] . '</th>';
                echo '<td scope="row">' . $row["product_id"] . '</td>';
                echo '<td scope="row">' . $row["quantity"] . '</td>';
                echo '<td scope="row">' . $row["item"] . '</td>';
                echo '<td scope="row">' . $row["unit_price"] . '</td>';
                echo '<td scope="row">' . $row["tax"] . '</td>';
                echo '<td scope="row">' . $row["discount"] . '</td>';
                echo '<td scope="row">' . $row["total"] . '</td>';
                echo '</tr>';
            }
        } else {
            echo "0 results";
        }
        $conn_oop->close();
        ?>
        </tbody>
    </table>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>
</html>
