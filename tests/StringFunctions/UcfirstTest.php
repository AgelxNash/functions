<?php namespace AgelxNash\Functions\Test\StringFunctions;

use PHPUnit\Framework\TestCase;

class UcfirstTest extends TestCase
{
    public function testASuccess()
    {
        $data = [
            [
                'in' => 'иванов иван иванович',
                'out' => 'Иванов иван иванович'
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], mb_ucfirst($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testBSuccess()
    {
        $data = [
            [
                'in' => "Иванов иван иванович",
                'out' => "Иванов иван иванович",
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], mb_ucfirst($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testCSuccess()
    {
        $data = [
            [
                'in' => 'ivanov ivan',
                'out' => 'Ivanov ivan'
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], mb_ucfirst($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testDSuccess()
    {
        $data = [
            [
                'in' => '1 1',
                'out' => '1 1'
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], mb_ucfirst($item['in']), 'Test #' . ($num + 1));
        }
    }
}
