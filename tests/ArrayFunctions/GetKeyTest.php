<?php namespace AgelxNash\Functions\Test\ArrayFunctions;

use PHPUnit\Framework\TestCase;

class GetKeyTest extends TestCase
{
    protected $data = [
        'a' => 'asd',
        'b' => 'qwe',
        'c' => 'zxc',
        'aa' => [
            'a' => '111',
            'b' => '222',
            'c' => '333'
        ],
        'd' => null,
        'e' => [444, 555, 666]
    ];

    public function testDefaultSuccess()
    {
        $this->assertEquals('default', get_key($this->data, 'z', 'default'));
    }

    public function testDefaultNullSuccess()
    {
        $this->assertEquals(null, get_key($this->data, 'd', 'default'));
    }

    public function testKeyBSuccess()
    {
        $this->assertEquals('qwe', get_key($this->data, 'b', 'default'));
    }

    public function testKeyEValidSuccess()
    {
        $this->assertEquals([444, 555, 666], get_key($this->data, 'e', 'default', function ($val) {
            return is_array($val);
        }));
    }

    public function testKeyAANoValidError()
    {
        $this->assertEquals('default', get_key($this->data, 'aa', 'default', function ($val) {
            return !is_array($val);
        }));
    }
}
