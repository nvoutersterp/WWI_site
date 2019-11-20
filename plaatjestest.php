<html>
<br><br><br>
<form action="" method="POST" enctype="multipart/form-data">
    <table>

    </table>
</form>
</html>


<?php
include "function.php";
$dbname = "wideworldimporters";
$conn = dbconect();

mysqli_select_db($conn, $dbname) or die ("could not connect");

$blobimage = addslashes(file_get_contents($_FILES['files']['tmp_name'][$key]));

foreach ()


?>


<?php
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    # Connect to DB
    # SQL Statement
    $sql = "SELECT `idimage` FROM `users` WHERE id=" . mysqli_real_escape_string($_GET['id']) . ";";
    $result = mysqli_query("$sql") or die("Invalid query: " . mysqli_error());

    # Set header
    header("Content-type: image/png");
    echo mysqli_result($result, 0);
}
else
    echo 'Please check the ID!';
?>
<!--//include "function.php";-->
<!--//$dbname = "wideworldimporters";-->
<!--//$output = '';-->
<!--//$conn = dbconect();-->
<!--//$output = "";-->
<!--//if (isset($_POST['verzenden'])){-->
<!--//      <img height="300" width="300" src="data:image;base64,' . $row[1]. ' ">
<!--//    mysqli_select_db($conn, $dbname) or die ("could not connect");-->
<!--//-->
<!--//    $query = mysqli_query($conn,"select photo from stockitems");-->
<!--//    $rec = $query->fetch_row();-->
<!--//    print $rec[0];-->
<!--//-->
<!-- echo '<img height = "60" width = "80" src="data:image/jpeg;base64,'.base64_encode( $row['Photo'] ).'"/>'-->


</html>