<?php

namespace Tandiljuan\Collection\Tests;

use Codeception\Stub;
use DateTime;

class CollectionCest
{
    public function testMuliTypeCollection(UnitTester $I)
    {
        $collection = Stub::make('\Tandiljuan\Collection\AbstractCollection');
        $items = [1, 'a', new DateTime('2001-01-01 01:01:01')];

        $I->testEmptyToFullCollection($collection, $items);
    }

    public function testIntegerCollection(UnitTester $I)
    {
        $collection = Stub::make('\Tandiljuan\Collection\AbstractCollection', ['itemType' => 'integer']);
        $items = [1, 2, 3, 4];

        $I->testEmptyToFullCollection($collection, $items);
    }

    public function testStringCollection(UnitTester $I)
    {
        $collection = Stub::make('\Tandiljuan\Collection\AbstractCollection', ['itemType' => 'string']);
        $items = ['a', 'b', 'c', 'd'];

        $I->testEmptyToFullCollection($collection, $items);
    }

    public function testDateTimeCollection(UnitTester $I)
    {
        $collection = Stub::make('\Tandiljuan\Collection\AbstractCollection', ['itemType' => '\DateTime']);
        $items = [
            new DateTime('2001-01-01 01:01:01'),
            new DateTime('2002-02-02 02:02:02'),
            new DateTime('2003-03-03 03:03:03'),
            new DateTime('2004-04-04 04:04:04'),
            new DateTime('2005-05-05 05:05:05'),
        ];

        $I->testEmptyToFullCollection($collection, $items);
    }

    public function testMixedIndexCollection(UnitTester $I)
    {
        $collection = Stub::make('\Tandiljuan\Collection\AbstractCollection', ['offsetType' => null]);
        $items = [1, 'a', 'key' => new DateTime('2001-01-01 01:01:01')];

        $I->testEmptyToFullCollection($collection, $items);
    }

    public function testIntegerIndexCollection(UnitTester $I)
    {
        $collection = Stub::make('\Tandiljuan\Collection\AbstractCollection', ['offsetType' => 'integer']);
        $items = [1, 'a', new DateTime('2001-01-01 01:01:01')];

        $I->testEmptyToFullCollection($collection, $items);
    }

    public function testStringIndexCollection(UnitTester $I)
    {
        $collection = Stub::make('\Tandiljuan\Collection\AbstractCollection', ['offsetType' => 'string']);
        $items = ['key1' => 1, 'key2' => 'a', 'key3' => new DateTime('2001-01-01 01:01:01')];

        $I->testEmptyToFullCollection($collection, $items);
    }
}
