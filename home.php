<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>WWI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<?php
include 'function.php';

$conn = dbconect();

$sql = "SELECT temperature FROM vehicletemperatures";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "temp: " . $row["temperature"] . "<br>";
    }
} else {
    echo "geen reseltaten";
}

$conn->close();
?>

</body>
</html>