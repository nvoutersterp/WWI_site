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

$query = mysqli_query($conn,"SELECT * FROM stockitems" );

while ($row = mysqli_fetch_array($query)) {
    $result = $row;

    print"<td>";?> <img src="<?php echo $row["Photo"]; ?> " height="100" width="100"> <?php echo "</td>";


    }
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