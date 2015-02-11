<?php namespace ArrayFunctions;

class MakeArrayTest extends \PHPUnit_Framework_TestCase{

	protected $data = array(
		'menutitle' => 'example',
		'pagetitle' => 'test',
		'tv.price' => '300',
		'tv.color' => 'red',
		'user.id' => 1,
		'user.fullname' => 'Agel_Nash'
	);

	public function testDotSuccess()
	{
		$out = array(
			'menutitle' => 'example',
			'pagetitle' => 'test',
			'tv' => array(
				'price' => 300,
				'color' => 'red'
			),
			'user' => array(
				'id' => 1,
				'fullname' => 'Agel_Nash'
			)
		);
		$this->assertEquals($out, make_array($this->data, '.'));
	}

	public function testEmptySuccess()
	{
		$this->assertEquals($this->data, make_array($this->data, ''));
	}
}