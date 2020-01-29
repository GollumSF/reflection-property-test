# Reflection Property Test

[![Build Status](https://travis-ci.org/GollumSF/reflection-property-test.svg?branch=master)](https://travis-ci.org/GollumSF/reflection-property-test)
[![Coverage](https://coveralls.io/repos/github/GollumSF/reflection-property-test/badge.svg?branch=master)](https://coveralls.io/github/GollumSF/reflection-property-test)
[![License](https://poser.pugx.org/gollumsf/reflection-property-test/license)](https://packagist.org/packages/gollumsf/reflection-property-test)
[![Latest Stable Version](https://poser.pugx.org/gollumsf/reflection-property-test/v/stable)](https://packagist.org/packages/gollumsf/reflection-property-test)
[![Latest Unstable Version](https://poser.pugx.org/gollumsf/reflection-property-test/v/unstable)](https://packagist.org/packages/gollumsf/reflection-property-test)
[![Discord](https://img.shields.io/discord/671741944149573687?color=purple&label=discord)](https://discord.gg/xMBc5SQ)

Add trait for reflection data

## Install:

```
composer require gollumsf/reflection-property-test
```

## Usage:

```php

use GollumSF\ReflectionPropertyTest\ReflectionPropertyTrait;

class MyPrivate {
	private $dataPrivate = 10;
	private function functionPrivate($value) {
		return 11 + $value;
	}
}

class MyExtend extends MyPrivate {
}

class MyTest extends TestCase {
	
	use ReflectionPropertyTrait;
	
	testMyFunction() {
		$obj = new MyPrivate();
		$this->assertEqual($this->reflectionGetValue($obj, 'reflectionGetValue'), 10);
		
		$this->reflectionSetValue($obj, 'reflectionGetValue', 20);
		$this->assertEqual($this->reflectionGetValue($obj, 'reflectionGetValue'), 20);
		
		$this->assertEqual($this->reflectionGetValue($obj, 'functionPrivate', [ 19 ]), 30);
		
		$obj2 = new MyExtend();
		$this->assertEqual($this->reflectionGetValue($obj2, 'reflectionGetValue', MyPrivate::class), 10);
		
		$this->reflectionSetValue($obj2, 'reflectionGetValue', 20, MyPrivate::class);
		$this->assertEqual($this->reflectionGetValue($obj2, 'reflectionGetValue', MyPrivate::class), 20);
		
		$this->assertEqual($this->reflectionGetValue($obj2, 'functionPrivate', [ 19 ], MyPrivate::class), 30);
	}
	
}
```
