<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Example class of which we can collect items
class Monkey implements \Collection\Identifiable
{
    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function greet()
    {
        return "Hi! I am " . $this->name;
    }

    // The `itemIdentifier` method is required because
    // this class implements the ItemInterface
    public function identifier()
    {
        return $this->getName();
    }
}

// Second example class of a different type
class Snake implements \Collection\Identifiable
{
    // The `itemIdentifier` method is required because
    // this class implements the ItemInterface
    public function identifier()
    {
        return 'Hissss';
    }
}

class Zoo
{
    protected $monkeys;
    protected $snakes;

    public function __construct()
    {
        $this->monkeys = new \Collection\TypedArray(Monkey::class);
        $this->snakes = new \Collection\TypedArray(Snake::class);
    }

    public function getMonkeys()
    {
        return $this->monkeys;
    }

}
