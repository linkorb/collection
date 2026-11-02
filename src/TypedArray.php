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

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function offsetSet(mixed $offset, mixed $value): void
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

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetUnset(mixed $offset): void
    {
       unset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (!$this->offsetExists($offset)) {
            throw new CollectionException('Unknow offset: ' . $offset);
        }
        return $this->items[$offset];
    }

    public function __serialize(): array
    {
        return [
            'className' => $this->className,
            'items' => $this->items,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->className = $data['className'] ?? null;
        $this->items = $data['items'] ?? [];
    }

    public function serialize()
    {
        return serialize($this->__serialize());
    }

    public function unserialize($data)
    {
        $payload = unserialize($data);
        $this->__unserialize(is_array($payload) ? $payload : []);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
