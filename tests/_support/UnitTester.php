<?php

namespace Tandiljuan\Collection\Tests;

/**
 * Inherited Methods.
 *
 * @method void                    wantToTest($text)
 * @method void                    wantTo($text)
 * @method void                    execute($callable)
 * @method void                    expectTo($prediction)
 * @method void                    expect($prediction)
 * @method void                    amGoingTo($argumentation)
 * @method void                    am($role)
 * @method void                    lookForwardTo($achieveValue)
 * @method void                    comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;

    /**
     * Test an empty collection that will be filled with the given items.
     *
     * @param \Tandiljuan\Collection\Contract\CollectionInterface $collection Empty collection
     * @param array                                               $items      Items used to fill the collection
     */
    public function testEmptyToFullCollection($collection, array $items)
    {
        if (empty($items)) {
            throw new \Exception('The array of items can not be empty');
        }

        try {
            $collection[0];
            $intIndex = true;
        } catch (\Exception $e) {
            $intIndex = false;
        }

        try {
            $collection['a'];
            $stringIndex = true;
        } catch (\Exception $e) {
            $stringIndex = false;
        }

        $this->assertInstanceOf('\Tandiljuan\Collection\Contract\CollectionInterface', $collection);
        $this->assertEmpty($collection);
        $this->assertCount(0, $collection);

        foreach ($items as $k => $i) {
            $collection[$k] = $i;
        }

        $lastKey = array_slice(array_keys($items), -1)[0];
        $inexistentKey = $intIndex ? rand(1000000, 9999999) : hash('sha512', time());

        $this->assertNotEmpty($collection);
        $this->assertCount(count($items), $collection);
        $this->assertArrayHasKey($lastKey, $collection);
        $this->assertArrayNotHasKey($inexistentKey, $collection);

        foreach ($items as $k => $i) {
            $this->assertEquals($i, $collection[$k]);
        }

        foreach ($collection as $k => $i) {
            $this->assertEquals($i, $items[$k]);
        }

        $this->assertEquals(json_encode($items), json_encode($collection));

        $clone = clone $collection;

        $this->assertEquals($collection, $clone);
        $this->assertNotSame($collection, $clone);

        foreach (array_keys($items) as $k) {
            unset($clone[$k]);
        }

        try {
            $clone[$intIndex ? 0 : 'a'] = 1;
            $intType = true;
            unset($clone[$intIndex ? 0 : 'a']);
        } catch (\Exception $e) {
            $intType = false;
        }

        try {
            $clone[$intIndex ? 0 : 'a'] = 'a';
            $stringType = true;
            unset($clone[$intIndex ? 0 : 'a']);
        } catch (\Exception $e) {
            $stringType = false;
        }

        $this->assertEmpty($clone);
        $this->assertCount(0, $clone);

        if (!$intIndex || !$stringIndex) {
            $errorKey = $intIndex ? 'a' : 1;
            $correctItem = $items[$lastKey];
            $this->expectException(\Tandiljuan\Collection\Exception\InvalidOffsetType::class, function () use ($clone, $errorKey, $correctItem) {
                $clone[$errorKey] = $correctItem;
            });
        }

        if (!$intType || !$stringType) {
            $correctKey = $intIndex ? 0 : 'a';
            $errorItem = $intType ? 'a' : 1;
            $this->expectException(\Tandiljuan\Collection\Exception\InvalidItemType::class, function () use ($clone, $correctKey, $errorItem) {
                $clone[$correctKey] = $errorItem;
            });
        }
    }
}
