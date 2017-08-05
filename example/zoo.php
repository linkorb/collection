<?php

require_once 'common.php';

$zoo = new Zoo();
$monkey = new Monkey('Bubbles');

$zoo->getMonkeys()->add($monkey);

print_r($zoo);
