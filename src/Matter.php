<?php
namespace Belt;

use Belt\Matter\Node;

/**
 * @author Ramon Kleiss <ramonkleiss@gmail.com>
 */
class Matter
{
    /**
     * Create a new tree from the given object.
     *
     * @param stdClass
     *
     * @return node
     */
    public static function create($object)
    {
        return new Node($object);
    }

    /**
     * Create a new tree from the given JSON string.
     *
     * @param mixed
     *
     * @return Node
     */
    public static function fromJson($json)
    {
        return static::create(json_decode($json));
    }
}
