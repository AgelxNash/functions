<?php namespace AgelxNash\Functions\Test\StringFunctions;

use PHPUnit\Framework\TestCase;

class LcfirstTest extends TestCase
{
    public function testASuccess()
    {
        $data = [
            [
                'in' => '1 1',
                'out' => '1 1'
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], mb_lcfirst($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testBSuccess()
    {
        $data = [
            [
                'in' => 'Ivanov ivan',
                'out' => 'ivanov ivan'
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], mb_lcfirst($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testCSuccess()
    {
        $data = [
            [
                'in' => "иванов иван иванович",
                'out' => "иванов иван иванович",
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], mb_lcfirst($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testDSuccess()
    {
        $data = [
            [
                'in' => 'Иванов иван иванович',
                'out' => 'иванов иван иванович'
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], mb_lcfirst($item['in']), 'Test #' . ($num + 1));
        }
    }
}
