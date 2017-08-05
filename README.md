Collection
==========

This library implements a few helpful collection classes and interfaces.

## TypedArray

This class behaves exactly like an array, but only allows items of a specified type:

    $monkeys = new \Collection\TypedArray(Monkey::class);

    $monkeys->add(new Monkey('Bubbles')); // OK
    $monkeys[] = new Monkey('King Kong'); // OK
    $monkeys->add(new Snake('Kaa')); // throws CollectionException

    // You can iterate over the collection
    foreach ($monkeys as $monkey) {
        echo $monkey->getName();
    }

## Adding items to a collection

You can add items in the regular array way:

    $monkeys[] = new Monkey('King Kong');

Or use the `add()` method

    $monkeys->add(new Monkey('King Kong'));

## Identifiable interface

The `Identifiable` class forces a class to implement the `identifier()` method. This method
should return a key that makes this instance of a class unique.
Maybe it's an ID, a key, a name, or an email address, as long as it uniquely identifies the item.

    class Monkey implements \Collection\Identifiable
    {
        protected $name;
        public function __construct($name)
        {
            $this->name = $name;
        }

        public function identifier()
        {
            return $this->name;
        }
    }

When adding instances of this class to a collection, the identifier will automatically be used as the key:

    $monkeys = new \Collection\TypedArray(Monkey::class);

    $m1 = new Monkey('George');
    $m2 = new Monkey('Koko');

    $monkeys[] = $m1; // array contains 1 item
    $monkeys[] = $m2; // array contains 2 item
    $monkeys[] = $m2; // array still contains 2 items!
    $monkeys->add($m2); // array still contains 2 items!

    $monkeys->hasKey('George')); // returns true
    $monkeys->hasKey('King Kong')); // returns false
    isset($monkeys['George']); // returns true

## Using collections in classes


    class Zoo
    {
        protected $monkeys;

        public function __construct()
        {
            $this->monkeys = new Collection\TypedArray(Monkey::class);
        }

        public function getMonkeys()
        {
            return $this->monkeys;
        }
    }
