<?php namespace AgelxNash\Functions\Test\StringFunctions;

use PHPUnit\Framework\TestCase;

class OneSpaceTest extends TestCase
{
    public function testASuccess()
    {
        $data = [
            [
                'in' => ' a  b  c',
                'out' => ' a b c'
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], one_space($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testBSuccess()
    {
        $data = [
            [
                'in' => '	    a	b	c',
                'out' => ' a b c'
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], one_space($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testCSuccess()
    {
        $data = [
            [
                'in' => '	a	    	b	    	c',
                'out' => ' a b c'
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], one_space($item['in']), 'Test #' . ($num + 1));
        }
    }

    public function testDSuccess()
    {
        $data = [
            [
                'in' => "a	\r\nb\r\n\r\n   c\r\n\r\n\r\nd",
                'out' => "a \r\nb\r\n\r\n c\r\n\r\n\r\nd"
            ]
        ];
        foreach ($data as $num => $item) {
            $this->assertEquals($item['out'], one_space($item['in']), 'Test #' . ($num + 1));
        }
    }
}
