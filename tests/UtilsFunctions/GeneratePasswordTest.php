<?php namespace UtilsFunctions;

class GeneratePasswordTest extends \PHPUnit_Framework_TestCase
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