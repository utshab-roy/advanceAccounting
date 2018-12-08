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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Inventory Report</title>
</head>
<body>
<div class="container">
    <nav>
        <div class="row mb-5">
            <a type="button" href="main.php" class="btn btn-primary mr-2"><i class="fas fa-file-invoice"></i>In Voice</a>
            <a type="button" href="journal.php" class="btn btn-secondary mr-2"><i class="fas fa-journal-whills"></i>Journal</a>
            <a type="button" href="inventory.php" class="btn btn-success mr-2"><i class="fas fa-indent"></i>Inventory</a>

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
            <th scope="col" class="text-center">Date & Time</th>
            <th scope="col">Product_id</th>
            <th scope="col">Quantity</th>
            <th scope="col">Item</th>
            <th scope="col">Unit_price</th>
            <th scope="col">Tax(15%)</th>
            <th scope="col">Discount</th>
            <th scope="col">Total</th>
        </tr>
        </thead>
        <tbody>
        <?php
        global $conn_oop;
        $sql = "SELECT * FROM inventory_report";
        $result = $conn_oop->query($sql);

        //this array is used for the chart value
        $chart = [];

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {

                //for the chart value
                $chart[$row["product_id"]] = $row["quantity"];

                echo '<tr>';
                echo '<th scope="row" class="text-center">' . $row["date"] . '</th>';
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

    <a href="print_inventory.php" target='_blank' class="btn btn-primary float-right" id="print_inventory">Print Inventory</a>

    <canvas id="myChart"></canvas>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<!--<script src="js/inventory_report.js"></script>-->

<script>
    //fires the script after the dom ready
    jQuery(document).ready(function ($) {
        var jArray = <?php echo json_encode($chart); ?>;
       // console.log(jArray);
       var product_id = [];
       var quantity = [];

       $.each(jArray, function(key, value) {
           // console.log(key+ ':' + value);
           product_id.push(key);
           quantity.push(value);
       });

       var ctx = document.getElementById('myChart').getContext('2d');
       var chart = new Chart(ctx, {
           // The type of chart we want to create
           type: 'bar',
           // The data for our dataset
           data: {
               labels: product_id,
               datasets: [{
                   label: "Stock in Inventory",
                   backgroundColor: 'rgb(255, 99, 132)',
                   borderColor: 'rgb(255, 99, 132)',
                   data: quantity,
               }]
           },

           // Configuration options go here
           options: {}
       });
   });//end of document ready function
</script>

</body>
</html>
