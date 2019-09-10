<?php
/**
 * Created by PhpStorm.
 * User: bnespinal
 * Date: 9/8/2019
 * Time: 9:30 PM
 */

$pagename = "Member - Update Password";
include_once "header.inc.php";

?>
<h2>Password Update</h2>
<?php
checkLogin();
//SET INITIAL VARIABLES
$showform = 1;  // show form is true
$errmsg = 0;
$errpassword = "";
$errpassword2 = "";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    /* ***********************************************************************
     * SANITIZE USER DATA
     * ***********************************************************************
     */
    $formdata['password'] = $_POST['password'];
    $formdata['password2'] = $_POST['password2'];

    /* ***********************************************************************
     * CHECK EMPTY FIELDS
     * Check for empty data for every required field
     * Do not do for things like apartment number, middle initial, etc.
     * CAUTION:  Radio buttons with 0 as a value = use isset() not empty()
     *    see https://www.htmlcenter.com/blog/empty-and-isset-in-php/
     * ***********************************************************************
     */

    if (empty($formdata['password'])) {$errpassword = "The password is required."; $errmsg = 1; }
    if (empty($formdata['password2'])) {$errpassword2 = "The confirmation password is required."; $errmsg = 1; }

    /* ***********************************************************************
     * CHECK MATCHING FIELDS
     * Check to see if important fields match
     * Usually used for passwords and sometimes emails.  We'll do passwords.
     * ***********************************************************************
     */

    $pattern = "/\r\r\n\n\t\0\x0B/";
    if(preg_match($pattern, $formdata['password']))
    {
        $errmsg = 1;
        $errpassword .= "The password does not meet Regex parameters.";
    }
    if(strlen($formdata['password']) < 8 || strlen($formdata['password']) > 64 )
    {
        $errmsg = 1;
        $errpassword .= "The password does not meet length requirements. Must be greater than 10 characters or less than 64.";
    }
    if(count_chars($formdata['password'], 1)==3)
    {
        $errmsg = 1;
        $errpassword .= "You have repeated a character more than is allowed!";
    }


    /* ***********************************************************************
     * CONTROL STATEMENT TO HANDLE ERRORS
     * ***********************************************************************
     */
    if($errmsg == 1)
    {
        echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
    }
    else{

        /* ***********************************************************************
         * HASH SENSITIVE DATA
         * Used for passwords and other sensitive data
         * If checked for matching fields, do NOT hash and insert both to the DB
         * ***********************************************************************
         */
        $hashedpwd = password_hash($formdata['password'], PASSWORD_BCRYPT);

        /* ***********************************************************************
         * INSERT INTO THE DATABASE
         * This is where we will be updating your password in the database! It binds the value of the
         * new password to the customer based on their unique ID number. Then you are automatically
         * logged out.
         * ***********************************************************************
         */

        try{
            $sql = "UPDATE customer 
                    SET password = :password
                    WHERE ID = :ID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':password', $hashedpwd);
            $stmt->bindValue(':ID', $_SESSION['ID']);
            $stmt->execute();

            $showform =0; //hide the form
            header("Location: logout.php?state=3");
        }
        catch (PDOException $e)
        {
            die( $e->getMessage() );
        }
    } // else errormsg
}//submit

//display form if Show Form Flag is true
if($showform == 1)
{
    ?>
    <form name="memberpwd" id="memberpwd" method="post" action="memberpwd.php">
        <table class = "center">
            <tr><th><label for="password">Password:</label><span class="error">*</span></th>
                <td><input name="password" id="password" type="password" size="40" placeholder="Required password" />
                    <span class="error"><?php if(isset($errpassword)){echo $errpassword;}?></span></td>
            </tr>
            <tr><th><label for="password2">Password Confirmation:</label><span class="error">*</span></th>
                <td><input name="password2" id="password2" type="password" size="40" placeholder="Required confirmation password" />
                    <span class="error"><?php if(isset($errpassword2)){echo $errpassword2;}?></span></td>
            </tr>
            <tr><th><label for="submit">Submit:</label></th>
                <td><input type="submit" name="submit" id="submit" value="submit"/></td>
            </tr>

        </table>
    </form>
    <?php
}//end showform
include_once "footer.inc.php";
?>








