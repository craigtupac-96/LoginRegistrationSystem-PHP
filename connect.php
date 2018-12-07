<?php

    $con = mysqli_connect('localhost', 'root', '');//, 'user-login');

    if(!$con){
		  die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    $db = mysqli_select_db($con, 'secappdb');

    if(!$db) {
        $createDB = "CREATE database secappdb";
        mysqli_query($con, $createDB);

        $createTable = "CREATE TABLE `users` (
             `id` int(5) NOT NULL AUTO_INCREMENT,
             `username` varchar(30) NOT NULL,
             `password` char(128) NOT NULL,
             `salt` varchar(60) NOT NULL,
             PRIMARY KEY (`id`),
             UNIQUE KEY `username` (`username`),
             UNIQUE KEY `salt` (`salt`)
            ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1";

        $con = mysqli_connect('localhost', 'root', '', 'secappdb');

        mysqli_query($con, $createTable);
    }