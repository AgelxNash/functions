<?php namespace UtilsFunctions;

class CheckEmailTest extends \PHPUnit_Framework_TestCase
{
	public function testExistsMail()
	{
		$this->assertFalse(check_email('agel_nash@xaker.ru', false));
	}

	public function testDnsError()
	{
		$this->assertEquals('dns', check_email('agel_nash@domain-not-found-for-test.del', true));
	}

	public function testErrorFormatA()
	{
		$this->assertEquals('format', check_email('qwe', false));
	}

	public function testErrorFormatB()
	{
		$this->assertEquals('format', check_email('qwe@', false));
	}

	public function testErrorFormatC()
	{
		$this->assertEquals('format', check_email('qwe@qwe', false));
	}

	public function testErrorFormatD()
	{
		$this->assertEquals('format', check_email('qwe@qwe@', false));
	}

	public function testErrorFormatE()
	{
		$this->assertEquals('format', check_email('.@qwe.ru', false));
	}
}