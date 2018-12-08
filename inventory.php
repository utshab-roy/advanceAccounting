<?php
session_start();

include 'config.php';
include 'functions.php';

//if the user is unable to login then redirect to the login page
if (!$_SESSION['logged_in']) {
    header("location:index.php");
    die();
}

$form_valid = true;

$product_id = $product_list = $dropdown_product_id = $quantity = $item = $unit_price = $discount = '';

//showing the session message if exists
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}

/**
 * Adding the new product Item into the inventory
 */
if (isset($_POST['submit']) && intval($_POST['submit']) == 1) {
    //creating the object
    $func = new All_function();

    if (isset($_POST['product_id'])) {
        if (!empty($_POST['product_id'])) {
            $product_id = $_POST['product_id'];

            $success_messages = $func->add_new_product($product_id);
            $_SESSION['message'] = $success_messages;

            header("location: inventory.php");
        }
    }
}//end of submit add product

/**
 * Adding the inventory  into the database
 */
if (isset($_POST['add_inventory']) && intval($_POST['add_inventory']) == 1) {
    //creating the object
    $func = new All_function();

    if (isset($_POST['dropdown_product_id'])) {
        if (!empty($_POST['dropdown_product_id'])) {
            $dropdown_product_id = $_POST['dropdown_product_id'];
        } else {
            $form_valid = false;
        }
    }

    if (isset($_POST['quantity'])) {
        if (!empty($_POST['quantity'])) {
            $quantity = $_POST['quantity'];
        } else {
            $form_valid = false;
        }
    }

    if (isset($_POST['item'])) {
        if (!empty($_POST['item'])) {
            $item = $_POST['item'];
        } else {
            $form_valid = false;
        }
    }

    if (isset($_POST['unit_price'])) {
        if (!empty($_POST['unit_price'])) {
            $unit_price = $_POST['unit_price'];
        } else {
            $form_valid = false;
        }
    }

    if (isset($_POST['discount'])) {
        if (!empty($_POST['discount'])) {
            $discount = $_POST['discount'];
        } else {
            $discount = 0;
        }
    }

    if ($form_valid) {
        $success_messages = $func->add_inventory($dropdown_product_id, $quantity, $item, $unit_price, $discount);
        $_SESSION['message'] = $success_messages;

        header("location: inventory.php");
    }

} //end of inventory add block

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <title>Inventort</title>
</head>
<body>
<div class="container">

    <nav>
        <div class="row mb-5">
            <a type="button" href="inventory.php" class="btn btn-success mr-2" >Inventory</a>
            <a type="button" href="main.php" class="btn btn-primary mr-2">Invoice</a>
            <a type="button" href="journal.php" class="btn btn-secondary mr-2">Journal</a>
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

    <div class="row">
        <div class="add_inventory col-8">
            <h3>add a new product</h3>
            <form action="" method="POST" id="inventory_form">
                <div class="form-group">
<!--                    <label for="dropdown_product_id">Select Product ID:</label>-->
                    <select name="dropdown_product_id" id="dropdown_product_id" class="js-example-basic-single" style="width: 50%">
                        <option value="">Select the product</option>
                        <?php
                        //creating the object
                        $func = new All_function();
                        $product_list = $func->get_product_list();
                        foreach ($product_list as $product):
                            echo '<option value="' . $product . '">' . $product . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" min="0" class="form-control" id="quantity" name="quantity">
                </div>

                <div class="form-group">
                    <label for="item">Description:</label>
                    <input type="text" class="form-control" id="item" name="item">
                </div>

                <div class="form-group">
                    <label for="unit_price">Unit Price:</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="unit_price" name="unit_price">
                </div>

                <div class="form-group">
                    <label for="discount">Discount Amount(if applicable in %):</label>
                    <input type="number" step="0.01" min="0" max="100" class="form-control" id="discount" name="discount">
                </div>

                <div class="form-group">
                    <button type="submit" name="add_inventory" value="1" class="btn btn-primary">Add Inventory</button>
                </div>
            </form>

            <h6>Tax(15%): <span id="tax_amount"></span></h6>
            <h6>Total Price: <span id="total"></span></h6>
        </div>

        <div class="add_product col-4">
            <h6>Create new Product:</h6>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="product_id">Product ID:</label>
                    <input type="text" class="form-control" id="product_id" name="product_id">
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" value="1" class="btn btn-primary">Add New Product</button>
                </div>
            </form>

            <h3>List of Products:</h3>
            <ul>
                <li>Apple</li>
                <li>Orange</li>
                <li>Banana</li>
            </ul>
        </div>
    </div>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="js/main.js"></script>

<script src="js/inventory.js"></script>
</body>
</html>
