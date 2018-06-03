<?php namespace AgelxNash\Functions\Test\StringFunctions;

use PHPUnit\Framework\TestCase;

class OneNewLineTest extends TestCase
{
    public function testASuccess()
    {
        $data = [
            [
                'in' => "a\r\n \r\nb",
                'out' => "a\r\n \r\nb"
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], one_new_line($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testBSuccess()
    {
        $data = [
            [
                'in' => "a \r\n\r\nb",
                'out' => "a \r\nb"
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], one_new_line($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testCSuccess()
    {
        $data = [
            [
                'in' => "a \r\nb",
                'out' => "a \r\nb"
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], one_new_line($item['in']), 'Test #' . ($num + 1));
        }
    }
}
