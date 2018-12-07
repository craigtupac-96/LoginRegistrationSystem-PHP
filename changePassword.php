<?php
    session_start();
    include('connect.php');
    include('functions.php');
    $errors = array();

    if(isset($_POST['change'])) {
        $oldPass = $_POST['oldPassword'];
        $newPass1 = $_POST['newPassword1'];
        $newPass2 = $_POST['newPassword2'];

        // error checking
        if (empty($oldPass)) {
            header('location: changePasswordForm.php?change=emptyOldPass');
            exit();
        }
        if (empty($newPass1)) {
            header('location: changePasswordForm.php?change=emptyNewPass');
            exit();
        }
        if (empty($newPass2)) {
            header('location: changePasswordForm.php?change=emptyNewRePass');
            exit();
        }
        if ($newPass1 != $newPass2) {
            array_push($errors, "The two passwords do not match");
            header('location: changePasswordForm.php?change=noPassMatch');
            exit();
        }
        if (strlen($newPass1) < 8) {
            header('location: changePasswordForm.php?change=pass8');
            exit();
        }
        if (!preg_match('/[A-Z]/', $newPass1)) {
            header('location: changePasswordForm.php?change=passUpper');
            exit();
        }
        if (!preg_match('/[0-9]/', $newPass1)) {
            header('location: changePasswordForm.php?change=passNum');
            exit();
        }

        if(count($errors) == 0) {
            //session_start();
            $username = $_SESSION['username'];

            $sql = "SELECT * FROM users WHERE username='$username'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_num_rows($query);

            if ($result == 1) {
                $row = mysqli_fetch_assoc($query);
                $salt = $row["salt"];
                $hashedPassword = $row["password"];

                $saltInput = $salt . $oldPass;
                $hashedInput = hash('sha256', $saltInput);

                if (check_passwords($hashedInput, $hashedPassword)) {
                    // new hash
                    $salt = generateRandomSalt();
                    $salted = $salt . $newPass1;

                    $newHashedPassword = hash('sha256', $salted);

                    //update
                    $sql = "UPDATE users SET password='$newHashedPassword', salt='$salt' WHERE username='$username'";
                    $query = mysqli_query($con, $sql);

                    header("Location: logout.php");

                }
                else{
                    header('location: changePasswordForm.php?change=oldPassWrong');
                    exit();
                }
            }
        }
    }

