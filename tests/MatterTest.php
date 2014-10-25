<?php
namespace Belt\Test;

use Belt\Matter;

class MatterTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateNodeFromJson()
    {
        $object = Matter::fromJson(file_get_contents(__DIR__.'/fixtures/object.json'));

        $this->assertInstanceOf('Belt\Matter\Node', $object);
    }

    public function testGetValueFromObjectProperty()
    {
        $object = Matter::fromJson(file_get_contents(__DIR__.'/fixtures/object.json'));

        $this->assertEquals('bar', $object->get('object')->get('foo')->get());
    }

    public function testGetValueFromArray()
    {
        $object = Matter::fromJson(file_get_contents(__DIR__.'/fixtures/object.json'));

        $this->assertEquals(1, $object->get('array')->get(0)->get());
        $this->assertEquals(2, $object->get('array')->get(1)->get());
        $this->assertEquals(3, $object->get('array')->get(2)->get());
        $this->assertEquals(4, $object->get('array')->get(3)->get());
        $this->assertNull($object->get('array')->get(4)->get());
    }

    public function testGetStringValue()
    {
        $object = Matter::fromJson(file_get_contents(__DIR__.'/fixtures/object.json'));

        $this->assertEquals('foo', $object->get('string')->get());
        $this->assertEquals(1234, $object->get('number')->get());
        $this->assertEquals(true, $object->get('boolean')->get());
    }

    public function testReturnNullForNonExistantProperties()
    {
        $object = Matter::fromJson(file_get_contents(__DIR__.'/fixtures/object.json'));

        $this->assertNull($object->get('not existing')->get('foo')->get());
    }

    public function testImplementArrayAccess()
    {
        $object = Matter::fromJson('[{"name":"Alice"},{"name":"Bob"}]');
        $this->assertEquals('Alice', $object[0]['name']->get());
        $this->assertEquals('Bob', $object[1]['name']->get());
        $this->assertNull($object[2]['name']->get());

        $this->assertTrue(isset($object[1]['name']));
        $this->assertFalse(isset($object[2]['name']));
    }

    public function testNodesAreReadOnly()
    {
        $object = Matter::fromJson('[{"name":"Alice"},{"name":"Bob"}]');

        $object[0]['name'] = 'foo';
        $this->assertEquals('Alice', $object[0]['name']->get());

        unset($object[0]['name']);
        $this->assertEquals('Alice', $object[0]['name']->get());
    }

    public function testIsIteratable()
    {
        $object = Matter::fromJson('[{"name":"Alice"}]');

        foreach ($object as $k => $user) {
            $this->assertEquals(0, $k);
            $this->assertEquals('Alice', $user->get('name')->get());
        }
    }

    public function testHaveMagicGetter()
    {
        $object = Matter::fromJson('[{"name":"Alice"},{"name":"Bob"}]');
        $this->assertEquals('Alice', $object[0]->name->get());
        $this->assertEquals('Bob', $object[1]->name->get());
        $this->assertNull($object[2]->name->get());
        $this->assertNull($object->foo->bar->baz->get());
    }
}
