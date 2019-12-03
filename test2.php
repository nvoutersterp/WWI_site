<?php
$tekst = 'hoi, hier staat tekst';
$pieces = explode(' ', 'hoi, hier staat tekst?');
$lastWord = array_pop($pieces);
print_r($pieces);

$sql = '';
foreach ($pieces as $index => $valeu) {
    $sql .= " " . $valeu;
}

$sqlTijdelijk = 'hoi hier staat tekst';

$sql = substr_replace($sqlTijdelijk, '', -3);

print ($sql);


