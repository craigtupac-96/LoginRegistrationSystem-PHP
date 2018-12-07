<?php
    session_start();
    include('connect.php');
    unset($_SESSION['badUser']);

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $inputPassword = $_POST['password'];
        $username = sanitizeInputLog($username);

        // error checking
        if(empty($username)){
            header('location: loginForm.php?log=emptyUser');
            exit();
        }
        if(empty($inputPassword)){
            header('location: loginForm.php?log=emptyPass');
            exit();
        }

        if(!empty($username) && !empty($inputPassword)){
            $sql = "SELECT * FROM users WHERE username='$username'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_num_rows($query);

            if ($result == 1) {
                $row = mysqli_fetch_assoc($query);
                $salt = $row["salt"];
                $hashedPassword = $row["password"];

                $saltInput = $salt . $inputPassword;
                $hashedInput = hash('sha256', $saltInput);
                // compare passwords
                if(check_passwords($hashedInput, $hashedPassword)){
                    $_SESSION['username'] = $username;
                    $_SESSION['success'] = "Welcome!"; // add success seciton
                }
                else{
                    $_SESSION['badUser'] = $username;
                    header('location: loginForm.php?log=wrongUserPass');
                    exit();
                }
            }
            else{
                $_SESSION['badUser'] = $username;
                header('location: loginForm.php?log=wrongUserPass');
                exit();
            }
        }
        if(isset($_SESSION['username'])) {
            header("location: success.php");
        }
        else{
            header("Location: loginForm.php");
        }
    }


    function check_passwords($input, $stored){
        for($i = 0; $i < strlen($input); $i++){
            if($input[$i] != $stored[$i]){
                return false;
            }
        }
        return true;
    }

    function sanitizeInputLog($input){
        $specCharsMap = array('&' => '&amp',
            '<' => '&lt',
            '>' => '&gt',
            '"' => '&quot',
            "'" => '&#x27',
            '/' => '&#x2F');  // for readability
        $newInput = "";

        for($i = 0; $i < strlen($input); $i++){
            if(array_key_exists($input[$i], $specCharsMap)){
                $newInput .= $specCharsMap[$input[$i]];
            }
            else{
                $newInput .= $input[$i];
            }
        }

        return $newInput;
    }











