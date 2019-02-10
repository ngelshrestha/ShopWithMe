<?php

    /*
     * Connecting to the database
     * */
    $host = "student-db.cse.unt.edu"; //Host name
    $username = "as1416"; //Login Credential: Username
    $password = "as1416"; //Login Credential: Password
    $dbname = "as1416"; // Database Name

    //Database connection variable
    $mysqli = @ mysqli_connect($host, $username, $password, $dbname);

?>