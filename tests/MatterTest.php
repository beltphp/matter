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
}
