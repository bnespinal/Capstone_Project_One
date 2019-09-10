<?php
/**
 * Created by PhpStorm.
 * User: bnespinal
 * Date:9/8/2019
 * Time: 7:18 PM
 */
$pagename = "Review Insert";
include_once "header.inc.php";
?>
<h2>Review Insert</h2>
<?php

checkLogin();

$showform = 1;
$errmsg = 0;
$errcomment = "";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $formdata['comment'] = trim($_POST['comment']);

    if (empty($formdata['comment'])) {$errcomment = "A comment is required."; $errmsg = 1; }

    if($errmsg == 1)
    {
        echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
    }
    else{

        /* ***********************************************************************
         * Comments!
         * Here, we have our commentinsert page. This is where we add a review to the list of
         * reviews on the reviews webpage on the site. With Once you click on the leave a review button
         * you are brought to a page with a text box where you enter a review to leave. Now, you must enter a comment,
         * or you can leave the page. The text box is set to not allow a blank comment to be entered (Look at error
         * code above). Once the review has been entered, the information is inserted into the comments data table and bound to your
         * username, since you are the one entering the comment, and only members can leave comments at this time.
         *
         * ***********************************************************************
         */

        try{
            $sql = "INSERT INTO comments (username, comment, inputdate)
                    VALUES (:username, :comment, :inputdate) ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':username', $_SESSION['username']);
            $stmt->bindValue(':comment', $formdata['comment']);
            $stmt->bindValue(':inputdate', $rightnow);
            $stmt->execute();

            $showform =0; //hide the form
            echo "<p class='success'>Thanks for leaving a review!</p>";
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
    <form name="commentinsert" id="commentinsert" method="post" action="commentinsert.php">
        <table class = "center">
            <tr><th><label for="comment">Review:</label><span class="error">*</span></th>
                <td><span class="error"><?php if(isset($errcomment)){echo $errcomment;}?></span>
                    <textarea name="comment" id="comment" placeholder="Required Comment"><?php if(isset($formdata['comment'])){echo $formdata['comment'];}?></textarea>
                </td>
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








