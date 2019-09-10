<?php

/* This page contains the code used to connect the webpage to the phpmyadmin database we are using for this project */
try{
    $connString = "mysql:host=localhost;dbname=csci409sp19";
    $user = "csci409sp19";
    $pass = "csci409sp19!";
    $pdo = new PDO($connString,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    die( $e->getMessage() );
}

