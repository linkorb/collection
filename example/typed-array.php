<?php

require_once 'common.php';

// Instantiate 5 monkeys
$m1 = new Monkey('Curious George');
$m2 = new Monkey('Bubbles');
$m3 = new Monkey('Koko');
$m4 = new Monkey('Donkey Kong');
$m5 = new Monkey('King Kong');

// Instantiate a collection of monkeys, and add the first 2
$monkeys = new \Collection\TypedArray(Monkey::class, [$m1, $m2]);

$monkeys->add($m3); // the collection now contains 3 monkeys
$monkeys->remove($m4);
$monkeys[] = $m5; // add monkey through array interface

try {
    $monkeys->add(new Snake());
} catch (\Exception $e) {
    echo "Can't add a Snake to the monkey collection\n";
}


print_r($monkeys);

// You can iterate over the monkey collection
foreach ($monkeys as $monkey) {
    echo $monkey->greet() . "\n";
}

if ($monkeys->hasKey('Bubbles')) {
    echo "Bubbles is part of the collection\n";
}

if ($monkeys->hasItem($m1)) {
    echo $m1->getName() . " is part of the collection\n";
}

// Get an item by key
$monkey = $monkeys->get('Koko');
echo $monkey->greet() . "\n";

// Get an item as array item
$monkey = $monkeys['Curious George'];
echo $monkey->greet() . "\n";
