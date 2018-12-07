<?php
    session_start();
    include('connect.php');
    include('functions.php');
    unset($_SESSION['badUser']);

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $inputPassword = $_POST['password'];
        $username = sanitizeInput($username);
        $userAgent = $_SERVER["HTTP_USER_AGENT"];
        $con = mysqli_connect('localhost', 'root', '', 'secappdb');

        // start attempts
        $sql = "SELECT * FROM lockout WHERE userAgent = '$userAgent' ORDER BY attemptTime DESC";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);

        $result = mysqli_num_rows($query);

        if($result == 3){
            $timeZone = (new DateTimeZone('Europe/Dublin'));
            $lockoutTime = 120; // this is 5 minutes in seconds

            $currentTime = new DateTime('now', $timeZone);
            $currentTimeStamp = date_timestamp_get($currentTime);

            $lastTimeDB = new DateTime($row['attemptTime'], $timeZone);
            $lastDBTimeStamp = date_timestamp_get($lastTimeDB);

            // calculate the difference
            $timeDiff = abs($currentTimeStamp - $lastDBTimeStamp);

            if($timeDiff < $lockoutTime){
                // output error - header
                $timeLeft = $lockoutTime - $timeDiff;
                $_SESSION['timeLeft'] = $timeLeft;
                header('location: loginForm.php?log=lockedOut');
                exit;
            }
            else{
                clearAttempts($userAgent);
            }
        }

        // error checking
        if(empty($username)){
            insertFailedAttempt($userAgent);
            header('location: loginForm.php?log=emptyUser');
            exit();
        }
        if(empty($inputPassword)){
            insertFailedAttempt($userAgent);
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
                    session_destroy();  // destroying session to create authenticated session
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['success'] = "Welcome!";
                    clearAttempts($userAgent);
                }
                else{
                    insertFailedAttempt($userAgent);
                    $_SESSION['badUser'] = $username;
                    header('location: loginForm.php?log=wrongUserPass');
                    exit();
                }
            }
            else{
                insertFailedAttempt($userAgent);
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














