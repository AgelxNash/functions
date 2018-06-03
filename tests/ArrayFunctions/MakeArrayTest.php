<?php namespace AgelxNash\Functions\Test\ArrayFunctions;

use PHPUnit\Framework\TestCase;

class MakeArrayTest extends TestCase
{
    protected $data = [
        'menutitle' => 'example',
        'pagetitle' => 'test',
        'tv.price' => '300',
        'tv.color' => 'red',
        'user.id' => 1,
        'user.fullname' => 'Agel_Nash'
    ];

    public function testDotSuccess()
    {
        $out = [
            'menutitle' => 'example',
            'pagetitle' => 'test',
            'tv' => [
                'price' => 300,
                'color' => 'red'
            ],
            'user' => [
                'id' => 1,
                'fullname' => 'Agel_Nash'
            ]
        ];
        $this->assertEquals($out, make_array($this->data, '.'));
    }

    public function testEmptySuccess()
    {
        $this->assertEquals($this->data, make_array($this->data, ''));
    }
}
