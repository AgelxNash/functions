<?php namespace AgelxNash\Functions\Test\UtilsFunctions;

use PHPUnit\Framework\TestCase;

class GeneratePasswordTest extends TestCase
{
    public function testOnlyChars()
    {
        $this->assertRegExp('/[A-Za-z]{10}/', generate_password(10, "Aa"));
    }

    public function testOnlyNumbers()
    {
        $this->assertRegExp('/\d{8}/', generate_password(8, "0"));
    }

    public function testAnyChars()
    {
        $this->assertRegExp('/[\W\w]{30}/', generate_password(30, "."));
    }
}
