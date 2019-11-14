
<head>('content-type: image/jpeg');</head>
<form action="" method="POST" enctype="multipart/form-data">
    <table>

    </table>
</form>
<input type="submit" name="verzenden">



<?php
include "productpagina.php";

mysqli_select_db($conn, $dbname) or die ("could not connect");

$query = mysqli_query($conn,"SELECT * FROM stockitems" );

while ($row = mysqli_fetch_array($query1)) {
    ?>
    <tr>
        <td> <?php echo '<img src"data:image;base64, ".base64_encode($row['image'])>'</td>
    </tr>


    <?php
    }


//include "function.php";
//$dbname = "wideworldimporters";
//$output = '';
//$conn = dbconect();
//$output = "";
//if (isset($_POST['verzenden'])){
//
//    mysqli_select_db($conn, $dbname) or die ("could not connect");
//
//    $query = mysqli_query($conn,"select photo from stockitems");
//    $rec = $query->fetch_row();
//    print $rec[0];
//
//
//}
//
