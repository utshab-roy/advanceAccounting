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
}
