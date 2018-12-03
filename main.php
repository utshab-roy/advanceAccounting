<?php
session_start();

include 'config.php';
include 'functions.php';

//if the user is unable to login then redirect to the login page
if(!$_SESSION['logged_in']) {
    header("location:index.php");
    die();
}


$form_valid = true;
$product_id = $quantity = $item = $unit_price = $discount = $payment = $customer_name = $customer_address = $customer_phone = '';

//showing the session message if exists
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}

//when the user wants to logout it will destroy the session
if (isset($_GET['logout']) && intval($_GET['logout']) == 1){
    session_destroy();
    header("location:index.php");
}

if (isset($_POST['submit']) && intval($_POST['submit']) == 1) {
    //creating the object
    $func = new All_function();

    if (isset($_POST['product_id'])) {
        if (!empty($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
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

    if (isset($_POST['payment'])) {
        if (!empty($_POST['payment'])) {
            $payment = $_POST['payment'];
        } else {
            $payment = 'cash payment';
        }
    }


    if (isset($_POST['customer_name'])) {
        if (!empty($_POST['customer_name'])) {
            $customer_name = $_POST['customer_name'];
        } else {
            $customer_name = 'Unnamed';
        }
    }

    if (isset($_POST['customer_address'])) {
        if (!empty($_POST['customer_address'])) {
            $customer_address = $_POST['customer_address'];
        } else {
            $customer_address = 'Address not given';
        }
    }

    if (isset($_POST['customer_phone'])) {
        if (!empty($_POST['customer_phone'])) {
            $customer_phone = $_POST['customer_phone'];
        } else {
            $customer_phone = 'Phone number not given';
        }
    }



    if ($form_valid) {
        $success_messages = $func->add_invoice($product_id, $quantity, $item, $payment, $unit_price, $discount, $customer_name, $customer_address, $customer_phone);
        $_SESSION['message'] = $success_messages;

        header("location: main.php");
    }
}//end of submit form

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

        <h3 class="text-center">In Voice</h3>

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


        <form action="" method="POST">
            <div class="row">
                <div class="col-9">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Product ID</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Item</th>
                            <th scope="col">unit_price</th>
                            <th scope="col">Tax</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <select name="product_id" id="product_id" class="">
                                        <option value="">Select product</option>
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
                            </td>


                            <td><input type="number" class="form-control" id="quantity" name="quantity"></td>
                            <td><input type="text" class="form-control" id="item" name="item"></td>
                            <td><input type="number" class="form-control" id="unit_price" name="unit_price"></td>
                            <td id="tax"></td>
                            <td id="total"></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="form-group">
                        <label for="discount">Discount:</label>
                        <input type="number" class="form-control" id="discount" name="discount" min="0" value="0">
                    </div>

                    <div class="form-group">
                        <select name="payment" id="payment" class="">
                            <option value="cash payment">Cash payment</option>
                            <option value="electronic paymet">Electronic payment</option>
                        </select>
                    </div>
                </div>
                <!--                End of Invoice details col-8-->

                <div class="col-3">
                    <h5>Customer details</h5>
                    <div class="form-group">
                        <label for="customer_name">Coustomaer Name:</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name">
                    </div>

                    <div class="form-group">
                        <label for="customer_address">Customer Address:</label>
                        <input type="text" class="form-control" id="customer_address" name="customer_address">
                    </div>

                    <div class="form-group">
                        <label for="customer_phone">Customer Phone No:</label>
                        <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                    </div>
                </div>
                <!--                End of col-4 Customer details-->

                <div class="form-group">
                    <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
                </div>
        </form>

        </div>






    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!--    <script src="js/main.js"></script>-->
</body>
</html>

