<?php
    // login
    function check_passwords($input, $stored){
        for($i = 0; $i < strlen($input); $i++){
            if($input[$i] != $stored[$i]){
                return false;
            }
        }
        return true;
    }

    function sanitizeInput($input){
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

    function insertFailedAttempt($userAgent){
        global $con;
        $sql = "INSERT INTO lockout (userAgent, attemptTime) VALUES ('$userAgent', NOW())";
        mysqli_query($con, $sql);
    }

    function clearAttempts($userAgent){
        global $con;
        $sql = "DELETE FROM lockout WHERE userAgent = '$userAgent'";
        mysqli_query($con, $sql);
    }

    // register - changePassword
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