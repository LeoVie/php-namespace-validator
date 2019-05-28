<?php

namespace LeoVie\PhpNf\Tests;

use Countable;
use Iterator;
use Mockery;
use Mockery\MockInterface;

class MockHelper
{
    public static function mockArrayIterator(string $className, array $items): MockInterface
    {
        $mockObject = Mockery::mock($className);
        if ($mockObject instanceof Iterator) {
            $counter = 0;
            $mockObject->shouldReceive('rewind')
                ->andReturnUsing(function() use (& $counter) {
                    $counter = 0;
                });
            $values = array_values($items);
            $keys = array_values(array_keys($items));
            $mockObject->shouldReceive('valid')
                ->andReturnUsing(function() use (& $counter, $values) {
                    return isset($values[$counter]);
                });
            $mockObject->shouldReceive('current')
                ->andReturnUsing(function() use (& $counter, $values) {
                    return $values[$counter];
                });
            $mockObject->shouldReceive('key')
                ->andReturnUsing(function() use (& $counter, $keys) {
                    return $keys[$counter];
                });
            $mockObject->shouldReceive('next')
                ->andReturnUsing(function() use (& $counter) {
                    ++$counter;
                });
        }
        if ($mockObject instanceof Countable) {
            $mockObject->shouldReceive('count')
                ->andReturn(count($items));
        }

        return $mockObject;
    }
}