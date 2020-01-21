# Reflection Property Test

Add trait for reflection data

## Install:

```
composer require gollumsf/reflection-property-test
```

## Usage:

```php

class MyPrivate {
	private $dataPrivate = 10;
	private function functionPrivate($value) {
		return 11 + $value;
	}
}

class MyExtend extends MyPrivate {
}

class MyTest extends TestCase {
	
	testMyFunction() {
		$obj = new MyPrivate();
		$this->assertEqual($this->reflectionGetValue($obj, 'reflectionGetValue'), 10);
		
		$this->reflectionSetValue($obj, 'reflectionGetValue', 20);
		$this->assertEqual($this->reflectionGetValue($obj, 'reflectionGetValue'), 20);
		
		$this->assertEqual($this->reflectionGetValue($obj, 'functionPrivate', [ 19 ]), 30);
		
		$obj2 = new MyExtend();
		$this->assertEqual($this->reflectionGetValue($obj2, 'reflectionGetValue'), 10, MyPrivate::class);
		
		$this->reflectionSetValue($obj, 'reflectionGetValue', 20, MyPrivate::class);
		$this->assertEqual($this->reflectionGetValue($obj2, 'reflectionGetValue'), 20, MyPrivate::class);
		
		$this->assertEqual($this->reflectionGetValue($obj2, 'functionPrivate', [ 19 ]), 30, MyPrivate::class);
	}
	
}
```
