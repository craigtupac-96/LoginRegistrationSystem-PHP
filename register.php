<?php
    session_start();
    include('connect.php');

    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        $username = sanitizeInputReg($username);

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
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Welcome! ";
            header('location: success.php');
    }

    function generateRandomSalt() {
        $randomSalt = "";
        $goodChars = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($goodChars) - 1;
        for($i = 0; $i <=59; $i++){
            $random = mt_rand(0, $max);
            $randomSalt .= $goodChars[$random];
        }

        if(isUnique($randomSalt)){
            return $randomSalt;
        }
        else {
            generateRandomSalt();
        }
    }

    function isUnique($salt){
        global $con;
        $sql = "SELECT * FROM users WHERE salt='$salt' LIMIT 1";
        $query = mysqli_query($con, $sql);
        $result = mysqli_fetch_assoc($query);

        if (!$result) {
            return true;
        }
        else{
            return false;
        }
    }

    function sanitizeInputReg($input){
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