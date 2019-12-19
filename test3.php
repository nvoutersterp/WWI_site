<?php
include "function.php";

$winkelmand['winkelmand'] = array(2 => 2, 5 => 1);
$besttelingID = "6";

database_write_order($winkelmand['winkelmand'], $besttelingID);