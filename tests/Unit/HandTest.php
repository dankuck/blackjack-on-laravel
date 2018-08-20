<?php

namespace Tests\Unit;

use App\Libs\Hand;

class HandTest extends \Tests\TestCase
{
    public function testExists()
    {
        new Hand([]);
    }

    public function testValues()
    {
        $hand = new Hand([]);
        $this->assertEquals([0], $hand->values());

        $hand = new Hand(['2H', 'QH', 'KH']);
        $this->assertEquals([22], $hand->values());

        $hand = new Hand(['AH']);
        $this->assertEquals([1, 11], $hand->values());

        $hand = new Hand(['AH', '2H']);
        $this->assertEquals([1 + 2, 11 + 2], $hand->values());

        $hand = new Hand(['AH', 'AH']);
        $this->assertEquals([1 + 1, 1 + 11, 11 + 1, 11 + 11], $hand->values());
    }

    public function testBestValue()
    {
        $hand = new Hand([]);
        $this->assertEquals(0, $hand->bestValue());
        $this->assertNotNull($hand->bestValue());

        $hand = new Hand(['2H', 'QH', 'KH']);
        $this->assertEquals(0, $hand->bestValue());
        $this->assertNotNull($hand->bestValue());

        $hand = new Hand(['AH']);
        $this->assertEquals(11, $hand->bestValue());

        $hand = new Hand(['AH', '2H']);
        $this->assertEquals(11 + 2, $hand->bestValue());

        $hand = new Hand(['AH', 'AH']);
        $this->assertEquals(1 + 11, $hand->bestValue());
    }
}
