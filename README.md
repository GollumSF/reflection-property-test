# Reflection Property Test

[![Build Status](https://github.com/GollumSF/reflection-property-test/actions/workflows/php_8.2.yml/badge.svg)](https://github.com/GollumSF/reflection-property-test/actions)
[![Coverage](https://coveralls.io/repos/github/GollumSF/reflection-property-test/badge.svg?branch=master)](https://coveralls.io/github/GollumSF/reflection-property-test)
[![License](https://poser.pugx.org/gollumsf/reflection-property-test/license)](https://packagist.org/packages/gollumsf/reflection-property-test)
[![Latest Stable Version](https://poser.pugx.org/gollumsf/reflection-property-test/v/stable)](https://packagist.org/packages/gollumsf/reflection-property-test)
[![Latest Unstable Version](https://poser.pugx.org/gollumsf/reflection-property-test/v/unstable)](https://packagist.org/packages/gollumsf/reflection-property-test)
[![Discord](https://img.shields.io/discord/671741944149573687?color=purple&label=discord)](https://discord.gg/xMBc5SQ)

Add trait for reflection data and call

## Requirements

- PHP >= 8.2

## Install:

```
composer require --dev gollumsf/reflection-property-test
```

## Usage:

```php

use GollumSF\ReflectionPropertyTest\ReflectionPropertyTrait;

class MyPrivate {
	private int $dataPrivate = 10;
	private function functionPrivate(int $value): int {
		return 11 + $value;
	}
}

class MyExtend extends MyPrivate {
}

class MyTest extends TestCase {

	use ReflectionPropertyTrait;

	public function testMyFunction(): void {
		$obj = new MyPrivate();
		$this->assertEquals($this->reflectionGetValue($obj, 'dataPrivate'), 10);

		$this->reflectionSetValue($obj, 'dataPrivate', 20);
		$this->assertEquals($this->reflectionGetValue($obj, 'dataPrivate'), 20);

		$this->assertEquals($this->reflectionCallMethod($obj, 'functionPrivate', [19]), 30);

		$obj2 = new MyExtend();
		$this->assertEquals($this->reflectionGetValue($obj2, 'dataPrivate', MyPrivate::class), 10);

		$this->reflectionSetValue($obj2, 'dataPrivate', 20, MyPrivate::class);
		$this->assertEquals($this->reflectionGetValue($obj2, 'dataPrivate', MyPrivate::class), 20);

		$this->assertEquals($this->reflectionCallMethod($obj2, 'functionPrivate', [19], MyPrivate::class), 30);
	}

}
```
