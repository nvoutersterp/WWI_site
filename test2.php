<?php
$tekst = 'hoi, hier staat tekst';
$pieces = explode('t', 'hoi, hier staat tekst?');
$lastWord = array_pop($pieces);
echo $lastWord;

