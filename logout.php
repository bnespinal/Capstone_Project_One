<?php
/**
 * Created by PhpStorm.
 * User: jennis
 * Date: 11/29/2017
 * Time: 10:40 PM
 */
session_start();
session_unset();
session_destroy();
//did they change passwords?  If so, provide specific message
if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['state']==3) {
    header("Location: confirm.php?state=3");
}
else
{
    header("Location: confirm.php?state=1");
}
exit();
?>


