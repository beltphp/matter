# Belt.`Matter`

[![Latest Version](http://img.shields.io/packagist/v/belt/matter.svg?style=flat-square)](https://github.com/beltphp/matter/releases)
[![Software License](http://img.shields.io/packagist/l/belt/matter.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/beltphp/matter/master.svg?style=flat-square)](https://travis-ci.org/beltphp/releases)
[![Coverage Status](http://img.shields.io/scrutinizer/coverage/g/beltphp/matter.svg?style=flat-square)](https://scrutinizer-ci.com/g/beltphp/matter/code-structure)
[![Quality Score](http://img.shields.io/scrutinizer/g/beltphp/matter.svg?style=flat-square)](https://scrutinizer-ci.com/g/beltphp/matter/)

> Proper object traversal

Belt.`Matter` is an utility library that makes working with JSON objects
a bit (actually a lot) more pleasant. It converts JSON strings, objects or
arrays to a proper tree structure that can be traversed without warnings or
errors.

## Installation

Via Composer.

```shell
$ composer require belt/matter
```

## Usage

When we use JSON in PHP, we usually have to use the properties of the JSON
object. This is really nice and all, but it doesn't work when a property
does not exist.

```php
$object = json_decode('{"foo":"bar","bar":[1, 2, 3, 4]","baz":"lorem ipsum"}');
$object->foo;       // "bar"
$object->something; // BOOM!
```

Well, that's not really nice, is it? We have to put guards around everytime we
want to use a property.

This is where Matter comes in handy!

```php
// Before
$object = json_decode('{"foo":"bar"}');
$object->foo;       // "bar"
$object->something; // BOOM!

// After
use Belt\Matter;

$object = Matter::fromJson('{"foo":"bar"}');
$object->get('foo')->get();         // "bar"
$object->get('something')->get();   // null
```

What Matter does for you, is convert a given JSON string or value into a tree
structure. This allows you to request nodes from the tree without being afraid
of errors/warnings that are thrown.

You can always access any value in the JSON object.

```php
$object = Matter::fromJson('{"foo":[1, 2, 3, 4],"bar":"lorem"}');
$object->get('foo')->get(0)->get(); // 1
$object->get('foo')->get(4)->get(); // null
$object->get('bar')->get();         // "lorem"

$object = Matter::fromJson('[{"name":"Alice"},{"name":"Bob"}]');
$object->get(0)->get('name')->get(); // "Alice"
$object->get(1)->get('name')->get(); // "Bob"
$object->get(2)->get('name')->get(); // null
```

Each Matter node also implements `ArrayAccess`, so that allows you to work
even faster!

```php
$object = Matter::fromJson('[{"name":"Alice"},{"name":"Bob"}]');
$object[0]['name']->get(); // "Alice"
$object[1]['name']->get(); // "Bob"
$object[2]['name']->get(); // null
```

Additionally, you can also safely access properties of the object without having
to use get to retrieve the property node.

```php
$object = Matter::fromJson('{"foo":{"bar":{"baz":42}}}');
$object->foo->bar->baz->get(); // 42
$object->baz->bar->foo->get(); // null
```

## Contributing

Please see [CONTRIBUTING](https://github.com/beltphp/matter/blob/master/CONTRIBUTING.md).

## License

Please see [LICENSE](https://github.com/beltphp/matter/blob/master/LICENSE).
