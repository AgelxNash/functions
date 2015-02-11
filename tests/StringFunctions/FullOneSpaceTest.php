<?php namespace StringFunctions;

class FullOneSpaceTest extends \PHPUnit_Framework_TestCase {
	public function testASuccess() {
		$data = array(
			array(
				'in' => "a	\r\nb\r\n\r\n   c\r\n\r\n\r\nd",
				'out' => "a b c d"
			)
		);
		foreach($data as $num => $item){
			$this->assertEquals($item['out'], full_one_space($item['in']), 'Test #'.($num+1));
		}
	}
	public function testBSuccess() {
		$data = array(
			array(
				'in' => "a\r\n \r\nb",
				'out' => "a b"
			)
		);
		foreach($data as $num => $item){
			$this->assertEquals($item['out'], full_one_space($item['in']), 'Test #'.($num+1));
		}
	}
	public function testCSuccess() {
		$data = array(
			array(
				'in' => ' a  b  c',
				'out' => ' a b c'
			)
		);
		foreach($data as $num => $item){
			$this->assertEquals($item['out'], full_one_space($item['in']), 'Test #'.($num+1));
		}
	}
}