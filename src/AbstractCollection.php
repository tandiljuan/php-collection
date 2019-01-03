<?php

namespace Tandiljuan\Collection;

use ArrayIterator;
use Tandiljuan\Collection\Contract\CollectionInterface;
use Tandiljuan\Collection\Exception\InvalidItemType as InvalidItemTypeException;
use Tandiljuan\Collection\Exception\InvalidOffsetType as InvalidOffsetTypeException;

abstract class AbstractCollection implements CollectionInterface
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var string|null
     *
     * @see http://php.net/manual/en/function.gettype.php
     *
     * Used to validate the type of the item to add in the collection. Don't
     * validate if it's `NULL`.
     */
    protected $itemType = null;

    /**
     * @var string|null
     *
     * @see http://php.net/manual/en/function.gettype.php
     * @see http://php.net/manual/en/language.types.array.php
     *
     * The offset can either be an integer or a string.
     *
     * Used to validate the type of the offset to access the collection. Don't
     * validate if it's `NULL`.
     */
    protected $offsetType = 'integer';

    /**
     * Object cloning.
     */
    public function __clone()
    {
        if (
            interface_exists($this->itemType)
            || class_exists($this->itemType)
        ) {
            foreach ($this->items as $key => $object) {
                $this->items[$key] = clone $object;
            }
        }
    }

    /**
     * Whether an offset exists.
     *
     * @see http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param null|int|string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->itemExist($offset);
    }

    /**
     * Assign a value to the specified offset.
     *
     * @see http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param null|int|string $offset
     * @param mixed           $value
     */
    public function offsetSet($offset, $value)
    {
        $this->addItem($value, $offset);
    }

    /**
     * Offset to retrieve.
     *
     * @see http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param null|int|string $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getItem($offset);
    }

    /**
     * Unset an offset.
     *
     * @see http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param null|int|string $offset
     */
    public function offsetUnset($offset)
    {
        $this->deleteItem($offset);
    }

    /**
     * Retrieve an external iterator.
     *
     * @see http://php.net/manual/en/iteratoraggregate.getiterator.php
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getItems());
    }

    /**
     * Count elements of an object.
     *
     * @see http://php.net/manual/en/countable.count.php
     *
     * @return int
     */
    public function count()
    {
        return count($this->getItems());
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @see http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->getItems();
    }

    /**
     * Add an item.
     *
     * @param mixed           $item
     * @param null|int|string $offset
     *
     * @return $this
     */
    protected function addItem($item, $offset = null)
    {
        $this->validateOffsetType($offset);
        $this->validateItemType($item);

        if (is_null($offset)) {
            $this->items[] = $item;
        } else {
            $this->items[$offset] = $item;
        }

        return $this;
    }

    /**
     * Set list of items.
     *
     * @param array $items
     * @param bool  $append False by default
     *
     * @return $this
     */
    protected function setItems(array $items, $append = false)
    {
        if (!(bool) $append) {
            $this->emptyItems();
        }

        foreach ($items as $i) {
            $this->addItem($i);
        }

        return $this;
    }

    /**
     * Delete an item by its index.
     *
     * @param null|int|string $offset
     *
     * @return $this
     */
    protected function deleteItem($offset)
    {
        $this->validateOffsetType($offset);

        unset($this->items[$offset]);

        return $this;
    }

    /**
     * Empty the list of items.
     *
     * @return $this
     */
    protected function emptyItems()
    {
        $this->items = [];

        return $this;
    }

    /**
     * Get an item by its index.
     *
     * @param null|int|string $offset
     * @param mixed           $default
     *
     * @return mixed
     */
    protected function getItem($offset, $default = null)
    {
        $this->validateOffsetType($offset);

        return isset($this->items[$offset]) ? $this->items[$offset] : $default;
    }

    /**
     * Get list of items.
     *
     * @return array
     */
    protected function getItems()
    {
        return $this->items;
    }

    /**
     * Check if an item exist in a given index.
     *
     * @param null|int|string $offset
     *
     * @return bool
     */
    protected function itemExist($offset)
    {
        $this->validateOffsetType($offset);

        return isset($this->items[$offset]);
    }

    /**
     * Validate item type.
     *
     * @param mixed $item
     *
     * @throws \Tandiljuan\Collection\Exception\InvalidItemType
     */
    protected function validateItemType($item)
    {
        if (
            $this->itemType
            && (
                is_object($item) && !is_a($item, $this->itemType)
                || !is_object($item) && gettype($item) != $this->itemType
            )
        ) {
            throw new InvalidItemTypeException("Item must be of type '{$this->itemType}'");
        }
    }

    /**
     * Validate offset type.
     *
     * @param null|int|string $offset
     *
     * @throws \Tandiljuan\Collection\Exception\InvalidOffsetType
     */
    protected function validateOffsetType($offset)
    {
        if (
            !is_null($offset)
            || 'string' === $this->offsetType
        ) {
            $checkType = false;
            $message = "Invalid offset type (must be 'integer' or 'string')";
            if (in_array($this->offsetType, ['integer', 'string'])) {
                $checkType = true;
                $message = "Offset must be of type '{$this->offsetType}'";
            }
            if (
                !is_null($offset) && !is_integer($offset) && !is_string($offset)
                || $checkType && gettype($offset) != $this->offsetType
            ) {
                throw new InvalidOffsetTypeException($message);
            }
        }
    }
}
