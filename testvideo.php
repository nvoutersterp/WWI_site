<!DOCTYPE html>
<html>
<body>
<?php
include 'function.php';
$conn = dbconect();
$dbname = "wideworldimporters";

$db = "mysql:host=localhost;dbname=cursus;port=3306";
$user = "root";
$pass = "";
$pdo = new PDO($db, $user, $pass);

$productID = 1;

$query1 = mysqli_query($conn, "SELECT * FROM stockitems S JOIN stockitemholdings H ON S.StockItemid = H.StockItemid WHERE S.StockItemid='$productID'") or die('Geen overeenkomst');

$row = mysqli_fetch_array($query1);

$naam = $row['StockItemName'];
$prijs = number_format((float)$row['UnitPrice'] * 0.9, 2, ',', '');
$vooraad = $row["QuantityOnHand"];
$omschrijving = $row["SearchDetails"];
$i = 1;

//voor de foto's
$photoRow = mysqli_query($conn, "select * from photo where StockItemID = '$productID'");
$issetPhoto = mysqli_num_rows($photoRow);
$rowphoto = mysqli_fetch_array($photoRow);
$p = 0;
$q = 0;
$photo2 = $rowphoto['photo'];

$query2 = mysqli_query($conn, "select * from photo where StockItemID = '$productID'");
$row1 = mysqli_fetch_array($query2);
$video = $row1['Video'];
$photo = $row1['photo'];

//voor video's
$query2 = mysqli_query($conn, "select * from video where StockItemID = '$productID'");
$row2 = mysqli_fetch_array($query2);
$video = $row2['video'];
?>

<!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
<div id="player"></div>

<script>
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height: '390',
            width: '640',
            videoId: '<?php print($video); ?>',
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        //event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    var done = false;
    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
            //setTimeout(stopVideo, 6000);
            done = true;
        }
    }
    function stopVideo() {
        player.stopVideo();
    }
</script>

</body>
</html>