<?php
session_start();
//if the user is unable to login then redirect to the login page
if(!$_SESSION['logged_in']) {
    header("location:index.php");
    die();
}


if ($_SESSION['logged_in'] = true){
    echo $_SESSION['name'];

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
        <a type="submit" href="main.php?logout=1" class="btn btn-danger float-right">Logout</a>
    </div>
</body>
</html>

