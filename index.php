<?php
session_start();
include_once 'config.php';
include_once 'functions.php';

//if the user is already logged in then redirect to the main page
if (isset($_SESSION['logged_in'])){
    if($_SESSION['logged_in']) {
        header("location:main.php");
        die();
    }
}

$user_name = $password = '';

//necessary array for the messages
$output = array();
$output['validation'] = 1;
$output['success_messages'] = array();
$output['validation_messages'] = array();


if (isset($_POST['submit']) && (intval($_POST['submit']) == 1)) {

    if (isset($_POST['user_name'])) {
        $user_name = $_POST['user_name'];
        if (empty($user_name)) {
            $validation_messages['user_name'] = 'Username is empty, give your Username';
            $output['validation'] = 0;
        }
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        if (empty($password)) {
            $validation_messages['password'] = 'Password can not be empty';
            $output['validation'] = 0;
        }
    }

    if(intval($output['validation']) == 1 ){
        $func = new All_function();

        //this function will check for the validation of the user login
        $success_messages = $func->login_validation($user_name, $password);
//        var_dump($_SESSION);
//        var_dump($success_messages);
        $output['success_messages'] = $success_messages;
        echo $output['success_messages'];
    }


}//end of submit block
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!--    <link rel="stylesheet" href="css/login_form.css">-->

    <title>Login</title>
</head>
<body id="LoginForm">
<div class="container">
    <h1 class="form-heading">login Form</h1>
    <div class="login-form">
        <div class="main-div">
            <div class="panel">
                <h2>Admin Login</h2>
                <p>Please enter your username and password</p>
            </div>
            <form method="post" id="Login" action="index.php">

                <div class="form-group">
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username">
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>

                <div class="forgot">
<!--                    <a href="reset.html">Forgot password?</a>-->
                </div>

                <button type="submit" name="submit" value="1" class="btn btn-primary">Login</button>

            </form>
        </div>
    </div>
</div>
</body>
</html>
