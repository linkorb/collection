<?php

namespace Collection;

class TypedArray implements CollectionInterface
{
    protected $className;
    protected $items = [];

    public function __construct($className, array $items = [])
    {
        $this->className = $className;
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add($item)
    {
        $this->offsetSet(null, $item);
    }

    public function set($offset, $item)
    {
        $this->offsetSet($offset, $item);
    }

    public function get($offset)
    {
        return $this->offsetGet($offset);
    }

    public function remove($value)
    {
        foreach ($this->items as $offset => $item) {
            if ($item === $value) {
                $this->offsetUnset($offset);
            }
        }
    }

    public function hasKey($offset)
    {
        return $this->offsetExists($offset);
    }

    public function hasItem($item)
    {
        return $this->offsetExists($item->identifier());
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    public function offsetSet($offset, $value)
    {
        if (!is_a($value, $this->className)) {
            throw new CollectionException("Item is not of class " . $this->className);
        }

        if (is_null($offset)) {
            // try to determine offset from identifier
            if (is_a($value, Identifiable::class)) {
                $offset = $value->identifier();
            }
        }

        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
           $this->items[$offset] = $value;
        }
   }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset)
    {
       unset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new CollectionException('Unknow offset: ' . $offset);
        }
        return $this->items[$offset];
    }

    public function serialize()
    {
        return serialize($this->data);
    }

    public function unserialize($data)
    {
        $this->data = unserialize($data);
    }

    public function count()
    {
        return count($this->items);
    }
}
