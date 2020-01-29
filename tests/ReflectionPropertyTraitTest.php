<?php
namespace Test\GollumSF\ReflectionPropertyTest;

use Doctrine\Persistence\Proxy;
use GollumSF\ReflectionPropertyTest\ReflectionPropertyTrait;
use PHPUnit\Framework\TestCase;

class ReflectionPropertyClass {
	use ReflectionPropertyTrait;
}

class DummyClass {

	private $privateValue = 'PRIVATE_VALUE';
	private $protectedValue = 'PROTECTED_VALUE';

	public function getPrivateValue() {
		return $this->privateValue;
	}

	public function getProtectedValue() {
		return $this->protectedValue;
	}

	private function privateFunctionNoArg() {
		return 'PRIVATE_FUNCTION_NO_ARG';
	}

	private function protectedFunctionNoArg() {
		return 'PROTECTED_FUNCTION_NO_ARG';
	}

	private function privateFunctionArgs($arg) {
		return 'PRIVATE_FUNCTION_'.$arg;
	}

	private function protectedFunctionArgs($arg) {
		return 'PROTECTED_FUNCTION_'.$arg;
	}
	
}

class SubDummyClass extends DummyClass {
}

class ProxyDummyClass extends DummyClass implements Proxy {
	public function __load() {}
	public function __isInitialized() {}
}

interface SubProxy extends Proxy {
}

class SubProxyDummyClass extends DummyClass implements SubProxy {
	public function __load() {}
	public function __isInitialized() {}
}



class ReflectionPropertyTraitTest extends TestCase
{
	public function testReflectionGetValue() {
		
		$obj = new DummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$this->assertEquals($reflectionPropertyClass->reflectionGetValue($obj, 'privateValue'), 'PRIVATE_VALUE');
		$this->assertEquals($reflectionPropertyClass->reflectionGetValue($obj, 'protectedValue'), 'PROTECTED_VALUE');
		
	}

	public function testReflectionGetValueSubClass() {

		$obj = new SubDummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$this->assertEquals($reflectionPropertyClass->reflectionGetValue($obj, 'privateValue', DummyClass::class), 'PRIVATE_VALUE');
		$this->assertEquals($reflectionPropertyClass->reflectionGetValue($obj, 'protectedValue', DummyClass::class), 'PROTECTED_VALUE');

	}

	public function testReflectionGetValueProxy() {

		$obj = new ProxyDummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$this->assertEquals($reflectionPropertyClass->reflectionGetValue($obj, 'privateValue', DummyClass::class), 'PRIVATE_VALUE');
		$this->assertEquals($reflectionPropertyClass->reflectionGetValue($obj, 'protectedValue', DummyClass::class), 'PROTECTED_VALUE');

	}

	public function testReflectionGetValueSubProxy() {

		$obj = new SubProxyDummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$this->assertEquals($reflectionPropertyClass->reflectionGetValue($obj, 'privateValue'), 'PRIVATE_VALUE');
		$this->assertEquals($reflectionPropertyClass->reflectionGetValue($obj, 'protectedValue'), 'PROTECTED_VALUE');

	}

	public function testReflectionSetValue() {

		$obj = new DummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$reflectionPropertyClass->reflectionSetValue($obj, 'privateValue', 'NEW_PRIVATE_VALUE');
		$reflectionPropertyClass->reflectionSetValue($obj, 'protectedValue', 'NEW_PROTECTED_VALUE');

		$this->assertEquals($obj->getPrivateValue(), 'NEW_PRIVATE_VALUE');
		$this->assertEquals($obj->getProtectedValue(), 'NEW_PROTECTED_VALUE');

	}

	public function testReflectionSetValueSubClass() {

		$obj = new SubDummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$reflectionPropertyClass->reflectionSetValue($obj, 'privateValue', 'NEW_PRIVATE_VALUE', DummyClass::class);
		$reflectionPropertyClass->reflectionSetValue($obj, 'protectedValue', 'NEW_PROTECTED_VALUE', DummyClass::class);

		$this->assertEquals($obj->getPrivateValue(), 'NEW_PRIVATE_VALUE');
		$this->assertEquals($obj->getProtectedValue(), 'NEW_PROTECTED_VALUE');

	}

	public function testReflectionSetValueProxy() {

		$obj = new ProxyDummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$reflectionPropertyClass->reflectionSetValue($obj, 'privateValue', 'NEW_PRIVATE_VALUE');
		$reflectionPropertyClass->reflectionSetValue($obj, 'protectedValue', 'NEW_PROTECTED_VALUE');

		$this->assertEquals($obj->getPrivateValue(), 'NEW_PRIVATE_VALUE');
		$this->assertEquals($obj->getProtectedValue(), 'NEW_PROTECTED_VALUE');

	}

	public function testReflectionSetValueSubProxy() {

		$obj = new SubProxyDummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$reflectionPropertyClass->reflectionSetValue($obj, 'privateValue', 'NEW_PRIVATE_VALUE');
		$reflectionPropertyClass->reflectionSetValue($obj, 'protectedValue', 'NEW_PROTECTED_VALUE');

		$this->assertEquals($obj->getPrivateValue(), 'NEW_PRIVATE_VALUE');
		$this->assertEquals($obj->getProtectedValue(), 'NEW_PROTECTED_VALUE');

	}

	public function testReflectionCallMethod() {

		$obj = new DummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'privateFunctionNoArg'), 'PRIVATE_FUNCTION_NO_ARG');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'protectedFunctionNoArg'), 'PROTECTED_FUNCTION_NO_ARG');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'privateFunctionArgs', [ 'ARG1' ]), 'PRIVATE_FUNCTION_ARG1');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'protectedFunctionArgs', [ 'ARG1' ]), 'PROTECTED_FUNCTION_ARG1');

	}

	public function testReflectionCallMethodSubClass() {

		$obj = new SubDummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'privateFunctionNoArg', [], DummyClass::class), 'PRIVATE_FUNCTION_NO_ARG');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'protectedFunctionNoArg', [], DummyClass::class), 'PROTECTED_FUNCTION_NO_ARG');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'privateFunctionArgs', [ 'ARG1' ], DummyClass::class), 'PRIVATE_FUNCTION_ARG1');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'protectedFunctionArgs', [ 'ARG1' ], DummyClass::class), 'PROTECTED_FUNCTION_ARG1');

	}

	public function testReflectionCallMethodProxy() {

		$obj = new ProxyDummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'privateFunctionNoArg'), 'PRIVATE_FUNCTION_NO_ARG');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'protectedFunctionNoArg'), 'PROTECTED_FUNCTION_NO_ARG');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'privateFunctionArgs', [ 'ARG1' ]), 'PRIVATE_FUNCTION_ARG1');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'protectedFunctionArgs', [ 'ARG1' ]), 'PROTECTED_FUNCTION_ARG1');

	}

	public function testReflectionCallMethodSubProxy() {

		$obj = new SubProxyDummyClass();
		$reflectionPropertyClass = new ReflectionPropertyClass();

		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'privateFunctionNoArg'), 'PRIVATE_FUNCTION_NO_ARG');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'protectedFunctionNoArg'), 'PROTECTED_FUNCTION_NO_ARG');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'privateFunctionArgs', [ 'ARG1' ]), 'PRIVATE_FUNCTION_ARG1');
		$this->assertEquals($reflectionPropertyClass->reflectionCallMethod($obj, 'protectedFunctionArgs', [ 'ARG1' ]), 'PROTECTED_FUNCTION_ARG1');

	}

}
