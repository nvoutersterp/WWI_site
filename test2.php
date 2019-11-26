<?php
$tekst = 'hoi, hier staat tekst';
$pieces = explode(' ', 'hoi, hier staat tekst?');
$lastWord = array_pop($pieces);
echo $lastWord;

