<?php
include "function.php";

$status = "hoi";
$orderId = "1576153866";

$conn = dbconect();
$sql = "update bestelling set paymentStatus='$status' where paymentID = '$orderId'";
$conn->query($sql);
$conn->close();