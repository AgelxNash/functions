<?php namespace StringFunctions;

class OneNewLineTest extends \PHPUnit_Framework_TestCase
{
	public function testASuccess()
	{
		$data = array(
			array(
				'in' => "a\r\n \r\nb",
				'out' => "a\r\n \r\nb"
			)
		);
		foreach ($data as $num => $item) {
			$this->assertEquals($item['out'], one_new_line($item['in']), 'Test #' . ($num + 1));
		}
	}

	public function testBSuccess()
	{
		$data = array(
			array(
				'in' => "a \r\n\r\nb",
				'out' => "a \r\nb"
			)
		);
		foreach ($data as $num => $item) {
			$this->assertEquals($item['out'], one_new_line($item['in']), 'Test #' . ($num + 1));
		}
	}

	public function testCSuccess()
	{
		$data = array(
			array(
				'in' => "a \r\nb",
				'out' => "a \r\nb"
			)
		);
		foreach ($data as $num => $item) {
			$this->assertEquals($item['out'], one_new_line($item['in']), 'Test #' . ($num + 1));
		}
	}
}