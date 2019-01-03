<?php

namespace Tandiljuan\Collection\Contract;

use ArrayAccess as ArrayAccessInterface;
use Countable as CountableInterface;
use IteratorAggregate as IteratorAggregateInterface;
use JsonSerializable as JsonSerializableInterface;

interface CollectionInterface extends
    ArrayAccessInterface,
    CountableInterface,
    IteratorAggregateInterface,
    JsonSerializableInterface
{
}
