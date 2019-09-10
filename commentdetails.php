<?php
/**
 * Created by PhpStorm.
 * User: bnespinal
 * Date: 9/9/2019
 * Time: 10:23 AM
 */
$pagename = "Comments";
require_once "header.inc.php";
?>
    <h2>See what people have to say about us!</h2>
<?php
if (isset($_SESSION['ID'])) {
    ?>

    <p id="statement"><a href='commentinsert.php'>Leave a review</a></p>
    <?php
}
/* ***********************************************************************
         * PRINTING COMMENTS!
         * Here, we have our commentdetails page. This is where we have the reviews from the comments
         * database printed out on the reviews page. Everything is pulled from the comments table and printed
         * in a table.
         * ***********************************************************************
         */
try{
    //query the data
    $sql = "SELECT * FROM comments";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



    echo "<table class='center'><tr><th>Member</th><th>Comment</th><th>Input Date</th></tr>";

    foreach ($result as $row) {
        echo "<tr><td>" .$row['username'] ."</td><td>" .$row['comment']. "</td><td>";
        echo date("l, F j, Y", $row['inputdate']);
        echo "</td></tr>";
    }
    echo"</table>";
}
catch (PDOException $e)
{
    die( $e->getMessage() );
}
require_once "footer.inc.php";









