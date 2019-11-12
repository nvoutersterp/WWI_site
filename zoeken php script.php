<HTML>
<head>
    <title>ZOEKEN</title>

</head>
<body>
<form action="zoeken%20php%20script.php" method="post">
    <input type="text" name="search" placeholder="zoeken naar producten...">
    <input type="submit" value=">>">
</form>
</body>

<?php
include 'function.php';
$dbname = "wideworldimporters";
$output = "";
$conn = dbconect();

mysqli_select_db($conn, $dbname) or die ("could not connect");

//verkrijgen
if(isset($_POST['search'])) {
    $searchq = $_POST['search'];
    $query1 = mysqli_query($conn, " SELECT *
 FROM stockitems 
 WHERE stockitemname LIKE '%$searchq%'") or die('Kan niet zoeken');
    $count = mysqli_num_rows($query1);
    if ($count == 0) {
        $output = 'Er zijn geen resultaten gevonden';
    } else {
        while ($row = mysqli_fetch_array($query1)) {
            $naamitem = $row['StockItemName'];
            $output .= '<div>' . $naamitem;
        }
    }
    mysqli_close($conn);
}
print("$output");


?>

</HTML>
