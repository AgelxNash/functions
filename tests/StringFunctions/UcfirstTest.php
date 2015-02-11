<?php namespace StringFunctions;

class UcfirstTest extends \PHPUnit_Framework_TestCase {
	public function testASuccess() {
		$data = array(
			array(
				'in' => 'иванов иван иванович',
				'out' => 'Иванов иван иванович'
			)
		);
		foreach($data as $num => $item){
			$this->assertEquals($item['out'], mb_ucfirst($item['in']), 'Test #'.($num+1));
		}
	}
	public function testBSuccess() {
		$data = array(
			array(
				'in' => "Иванов иван иванович",
				'out' => "Иванов иван иванович",
			)
		);
		foreach($data as $num => $item){
			$this->assertEquals($item['out'], mb_ucfirst($item['in']), 'Test #'.($num+1));
		}
	}
	public function testCSuccess() {
		$data = array(
			array(
				'in' => 'ivanov ivan',
				'out' => 'Ivanov ivan'
			)
		);
		foreach($data as $num => $item){
			$this->assertEquals($item['out'], mb_ucfirst($item['in']), 'Test #'.($num+1));
		}
	}
	public function testDSuccess() {
		$data = array(
			array(
				'in' => '1 1',
				'out' => '1 1'
			)
		);
		foreach($data as $num => $item){
			$this->assertEquals($item['out'], mb_ucfirst($item['in']), 'Test #'.($num+1));
		}
	}
}