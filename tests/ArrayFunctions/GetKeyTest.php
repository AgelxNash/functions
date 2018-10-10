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
            'c' => '333',
            '.' => [
                'z' => 123
            ]
        ],
        'd' => null,
        'e' => [444, 555, 666],
        'f.f' => 777,
        'g.g' => [
            'a' => 888,
            '.' => 99
        ],
        '.' => 999,
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
        $this->assertEquals([444, 555, 666], get_key($this->data, 'e', 'default', 'is_array'));
    }

    public function testKeyAANoValidError()
    {
        $this->assertEquals('default', get_key($this->data, 'aa', 'default', function ($val) {
            return !is_array($val);
        }));
    }

    public function testNestedKey()
    {
        $this->assertEquals('222', get_key($this->data, 'aa.b'));
    }

    public function testKeyWithDot()
    {
        $this->assertEquals(777, get_key($this->data, 'f.f'));
    }

    public function testNestedKeyWithDot()
    {
        $this->assertEquals(888, get_key($this->data, 'g.g.a'));
    }

    public function testNestedKeyNoValidError()
    {
        $this->assertEquals('default', get_key($this->data, 'aa.z', 'default'));
    }

    public function testOnlyDotKey()
    {
        $this->assertEquals(999, get_key($this->data, '.', 'default'));
    }

    public function testNestedOnlyDotKey()
    {
        $this->assertEquals(99, get_key($this->data, 'g.g..', 'default'));
    }

    public function testNestedOnlyDotKeyWithSubData()
    {
        $this->assertEquals(123, get_key($this->data, 'aa...z', 'default'));
    }
}
