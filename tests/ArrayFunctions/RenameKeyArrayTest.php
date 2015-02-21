<?php namespace ArrayFunctions;

class RenameKeyArrayTest extends \PHPUnit_Framework_TestCase
{

	protected $data = array(
		'key' => 'val',
		'subkey' => array(
			'a' => 'asd',
			'b' => 'zxc'
		)
	);

	public function testDefaultSuccess()
	{
		$out = array(
			'[+key+]' => 'val',
			'[+subkey.a+]' => 'asd',
			'[+subkey.b+]' => 'zxc',
			'[+subkey+]' => ''
		);
		$this->assertEquals($out, rename_key_array($this->data, '[', ']', '+', '.'));
	}

	public function testNoSeparatorSuccess()
	{
		$out = array(
			'[+key+]' => 'val',
			'[+subkey+]' => ''
		);
		$this->assertEquals($out, rename_key_array($this->data, '[', ']', '+', ''));
	}

	public function testNoAddPSSuccess()
	{
		$out = array(
			'[key]' => 'val',
			'[subkey.a]' => 'asd',
			'[subkey.b]' => 'zxc',
			'[subkey]' => ''
		);
		$this->assertEquals($out, rename_key_array($this->data, '[', ']', '', '.'));
	}

	public function testNoPrefixSuccess()
	{
		$out = array(
			'key+]' => 'val',
			'subkey.a+]' => 'asd',
			'subkey.b+]' => 'zxc',
			'subkey+]' => ''
		);
		$this->assertEquals($out, rename_key_array($this->data, '', ']', '+', '.'));
	}

	public function testNoSuffixSuccess()
	{
		$out = array(
			'[+key' => 'val',
			'[+subkey.a' => 'asd',
			'[+subkey.b' => 'zxc',
			'[+subkey' => ''
		);
		$this->assertEquals($out, rename_key_array($this->data, '[', '', '+', '.'));
	}

	public function testNoPrefixAndSuffixSuccess()
	{
		$out = array(
			'key' => 'val',
			'subkey.a' => 'asd',
			'subkey.b' => 'zxc',
			'subkey' => ''
		);
		$this->assertEquals($out, rename_key_array($this->data, '', '', '+', '.'));
	}

	public function testOnlySeparatorSuccess()
	{
		$out = array(
			'key' => 'val',
			'subkey.a' => 'asd',
			'subkey.b' => 'zxc',
			'subkey' => ''
		);
		$this->assertEquals($out, rename_key_array($this->data, '', '', '', '.'));
	}

	public function testNoSeparatorAndAddPSSuccess()
	{
		$out = array(
			'[key]' => 'val',
			'[subkey]' => ''
		);
		$this->assertEquals($out, rename_key_array($this->data, '[', ']', '', ''));
	}

	public function testEmptyParametersSuccess()
	{
		$out = array(
			'key' => 'val',
			'subkey' => ''
		);
		$this->assertEquals($out, rename_key_array($this->data, '', '', '', ''));
	}
}