<?php namespace AgelxNash\Functions\Test\ArrayFunctions;

use PHPUnit\Framework\TestCase;

class RenameKeyArrayTest extends TestCase
{
    protected $data = [
        'key' => 'val',
        'subkey' => [
            'a' => 'asd',
            'b' => 'zxc'
        ]
    ];

    public function testDefaultSuccess()
    {
        $out = [
            '[+key+]' => 'val',
            '[+subkey.a+]' => 'asd',
            '[+subkey.b+]' => 'zxc',
            '[+subkey+]' => ''
        ];
        $this->assertEquals($out, rename_key_array($this->data, '[', ']', '+', '.'));
    }

    public function testNoSeparatorSuccess()
    {
        $out = [
            '[+key+]' => 'val',
            '[+subkey+]' => ''
        ];
        $this->assertEquals($out, rename_key_array($this->data, '[', ']', '+', ''));
    }

    public function testNoAddPSSuccess()
    {
        $out = [
            '[key]' => 'val',
            '[subkey.a]' => 'asd',
            '[subkey.b]' => 'zxc',
            '[subkey]' => ''
        ];
        $this->assertEquals($out, rename_key_array($this->data, '[', ']', '', '.'));
    }

    public function testNoPrefixSuccess()
    {
        $out = [
            'key+]' => 'val',
            'subkey.a+]' => 'asd',
            'subkey.b+]' => 'zxc',
            'subkey+]' => ''
        ];
        $this->assertEquals($out, rename_key_array($this->data, '', ']', '+', '.'));
    }

    public function testNoSuffixSuccess()
    {
        $out = [
            '[+key' => 'val',
            '[+subkey.a' => 'asd',
            '[+subkey.b' => 'zxc',
            '[+subkey' => ''
        ];
        $this->assertEquals($out, rename_key_array($this->data, '[', '', '+', '.'));
    }

    public function testNoPrefixAndSuffixSuccess()
    {
        $out = [
            'key' => 'val',
            'subkey.a' => 'asd',
            'subkey.b' => 'zxc',
            'subkey' => ''
        ];
        $this->assertEquals($out, rename_key_array($this->data, '', '', '+', '.'));
    }

    public function testOnlySeparatorSuccess()
    {
        $out = [
            'key' => 'val',
            'subkey.a' => 'asd',
            'subkey.b' => 'zxc',
            'subkey' => ''
        ];
        $this->assertEquals($out, rename_key_array($this->data, '', '', '', '.'));
    }

    public function testNoSeparatorAndAddPSSuccess()
    {
        $out = [
            '[key]' => 'val',
            '[subkey]' => ''
        ];
        $this->assertEquals($out, rename_key_array($this->data, '[', ']', '', ''));
    }

    public function testEmptyParametersSuccess()
    {
        $out = [
            'key' => 'val',
            'subkey' => ''
        ];
        $this->assertEquals($out, rename_key_array($this->data, '', '', '', ''));
    }
}
