<?php

class All_function{

    /**
     * check the login condition and if valid then proceed for the main page.
     * @param $user_name
     * @param $password
     * @return array|string
     */
    public function login_validation($user_name, $password){

        global $conn_oop;
        $success_messages = array();
        $error_messages = array();

        $sql = "SELECT * FROM users WHERE user_name='$user_name' AND password=MD5('$password')";
        $result = $conn_oop->query($sql);
        if ($result->num_rows > 0) {
            $_SESSION['logged_in'] = true;
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['first_name'] . ' '. $row['last_name'];

            $success_messages['login'] = 'Successfully logged in !';
            header('location: main.php');

            return $success_messages;
        }
        else{
            return 'check your username and password again.';
        }
    }


    /**
     * add new product to the products table
     * @param $product_id
     * @return string
     */
    public function add_new_product($product_id){
        global $conn_oop;

        $sql = "INSERT INTO products (product_id) VALUES ('$product_id')";

        if ($conn_oop->query($sql) === TRUE) {
            return "New product created successfully";
        } else {
            return "Error: " . $sql . "<br>" . $conn_oop->error;
        }
    }

    /**
     * getting the product list
     * @return array
     */
    public function get_product_list(){
        global $conn_oop;

        $product_list = array();

        $sql = "SELECT product_id FROM products";

        $result = $conn_oop->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $product_list[] = $row["product_id"];
            }
            return $product_list;
        }
        return array();
    }

    public function add_inventory($product_id, $quantity, $item, $unit_price, $discount){
        global $conn_oop;
        $prev_quantity = $prev_tax = $prev_total = '';

        $sql = "SELECT * FROM inventory WHERE product_id='$product_id'";
        $result = $conn_oop->query($sql);

        if ($result->num_rows > 0) { //the porduct is already exists
            while($row = $result->fetch_assoc()) {
                $prev_quantity  = $row["quantity"];
                $prev_tax       = $row["tax"];
                $prev_total     = $row["total"];
            }
            $price  = $quantity * $unit_price;
            $tax    = 15 * $price / 100;
            $total  = $price + $tax - $discount;

            $quantity   = $quantity + $prev_quantity;
            $tax        = $tax + $prev_tax;
            $total      = $total + $prev_total;

//            $sql = "INSERT INTO inventory (product_id, quantity, item, unit_price, tax, total) VALUES ('$product_id', '$quantity', '$item', '$unit_price', '$tax', '$total')";
            $sql = "UPDATE inventory SET product_id='$product_id', quantity='$quantity', item='$item', unit_price='$unit_price', tax='$tax', total='$total' WHERE product_id='$product_id'";

            if ($conn_oop->query($sql) === TRUE) {
                return "New inventory added successfully";
            } else {
                return "Error: " . $sql . "<br>" . $conn_oop->error;
            }


        }else{//for the first time execution
            $price  = $quantity * $unit_price;
            $tax    = 15 * $price / 100;
            $total  = $price + $tax - $discount;

            $sql = "INSERT INTO inventory (product_id, quantity, item, unit_price, tax, total) VALUES ('$product_id', '$quantity', '$item', '$unit_price', '$tax', '$total')";

            if ($conn_oop->query($sql) === TRUE) {
                return "New inventory added successfully";
            } else {
                return "Error: " . $sql . "<br>" . $conn_oop->error;
            }
        }

    }

}//end of All_function class
