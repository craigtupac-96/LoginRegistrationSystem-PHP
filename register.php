<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location: loginForm.php');
    }
    include('connect.php');
    include('functions.php');

    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        $username = sanitizeInput($username);

        // error checking
        if(empty($username)){
            header('location: registrationForm.php?reg=emptyUser');
            exit();
        }
        if(empty($password1)){
            header('location: registrationForm.php?reg=emptyPass');
            exit();
        }
        if(empty($password2)){
            header('location: registrationForm.php?reg=emptyRePass');
            exit();
        }
        if($password1 != $password2){
            header('location: registrationForm.php?reg=noPassMatch');
            exit();
        }
        if(strlen($password1) < 8 ){
            header('location: registrationForm.php?reg=pass8');
            exit();
        }
        if (!preg_match('/[A-Z]/', $password1)){
            header('location: registrationForm.php?reg=passUpper');
            exit();
        }
        if (!preg_match('/[0-9]/', $password1)){
            header('location: registrationForm.php?reg=passNum');
            exit();
        }

        // check if username exists
        $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
        $query = mysqli_query($con, $sql);
        $result = mysqli_fetch_assoc($query);

        if ($result) {
            if ($result['username'] === $username) {
                header('location: registrationForm.php?reg=userExists');
                exit();
            }
        }
            // get unique salt
            $salt = generateRandomSalt();
            $salted = $salt . $password1;
            $hash = hash('sha256', $salted);

            $sql = "INSERT INTO `users` (`id`, `username`, `password`, `salt`) VALUES (NULL, '".$username."', '".$hash."', '".$salt."')";
            mysqli_query($con, $sql);

            session_destroy();
            header('location: loginForm.php?reg=success');
    }

