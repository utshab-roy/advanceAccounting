<?php
session_start();
//if the user is unable to login then redirect to the login page
if(!$_SESSION['logged_in']) {
    header("location:index.php");
    die();
}

//when the user wants to logout it will destroy the session
if (isset($_GET['logout']) && intval($_GET['logout']) == 1){
    session_destroy();
    header("location:index.php");
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous"/>

    <title>Main Page</title>
</head>
<body>
    <div class="container">
        <div class="top-panel">
            <a type="submit" href="main.php?logout=1" class="btn btn-danger float-right mb-3">Logout</a>
        </div>

        <nav>
            <div class="row mb-5">
                <button type="button" class="btn btn-primary mr-2">In Voice</button>
                <button type="button" class="btn btn-secondary mr-2">Journal</button>
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

        <h3 class="text-center">In Voice</h3>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Quantity</th>
                <th scope="col">Item</th>
                <th scope="col">Description</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Tax (15%)</th>
                <th scope="col">Total</th>
            </tr>
            </thead>
            <tbody>
            <tr id="input_row">
                <td scope="row"><input type="number" id="quantity" min="1" value="1" /></td>
                <td><input type="text" id="item" /></td>
                <td><input type="text" id="description" /></td>
                <td><input type="number" id="unit_price" min="1" value="1" /></td>
                <td id="tax"></td>
                <td id="total"></td>
                <td class="text-center"><button type="button" class="btn" id="view_btn">View</button></td>
            </tr>

            </tbody>
            <thead class="thead-light">
            <tr>
                <th scope="col">Subtotal</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col" id="subtotal"></th>
            </tr>
            </thead>
        </table>

        <button id="add_item" class="btn btn-primary">Add Item</button>
        <button id="insert-more" class="btn btn-danger">Discount(%)</button>

    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>
</html>

