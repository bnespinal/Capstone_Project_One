<?php
/**
 * Created by PhpStorm.
 * User: bnespinal
 * Date: 9/6/2019
 * Time: 10:07 AM
 */
session_start();
$currentfile = basename($_SERVER['PHP_SELF']); //get current filename
$rightnow = time(); //set current time

//turn on error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors','1');


ini_set( 'date.timezone', 'America/New_York');
date_default_timezone_set('America/New_York');

//required files

require_once "connect.inc.php";
require_once "functions.inc.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Capstone Project 1</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<header>
    <h1>CSCI 495 - Project One</h1>
    <nav align = "center">
        <div class="headerChange">
            <h3 class="headerChange">Feel free to navigate our website!</h3>
        </div>
        <?php require_once "nav.inc.php"; ?>
    </nav>
</header>
<main>


