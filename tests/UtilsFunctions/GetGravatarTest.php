<?php namespace AgelxNash\Functions\Test\UtilsFunctions;

use PHPUnit\Framework\TestCase;

class GetGravatarTest extends TestCase
{
    public function testWithSizeChars()
    {
        $this->assertEquals('//www.gravatar.com/avatar/bf12d44182c98288015f65c9861903aa?s=64', get_gravatar('agel_nash@xaker.ru', 64));
    }

    public function testDefaultSize()
    {
        $this->assertEquals('//www.gravatar.com/avatar/bf12d44182c98288015f65c9861903aa?s=32', get_gravatar('agel_nash@xaker.ru'));
    }
}
