<?php
    session_start();
    include('connect.php');
    $username = $_SESSION['username'];
    $false = 0;
    $sql = "UPDATE sessions SET loggedIn='$false' WHERE username='$username'";
    mysqli_query($con, $sql);
    session_destroy();
    header('location: loginForm.php');
