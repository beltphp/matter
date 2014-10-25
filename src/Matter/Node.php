<?php
namespace Belt\Matter;

/**
 * @author Ramon Kleiss <ramonkleiss@gmail.com>
 */
class Node implements \ArrayAccess, \Iterator
{
    /** @var mixed */
    private $value;

    /**
     * @param mixed
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param string
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @param string
     *
     * @return mixed
     */
    public function get($key = null)
    {
        if (is_null($key)) {
            return $this->value;
        } elseif (is_null($this->value)) {
            return new self(null);
        } elseif (is_array($this->value) && isset($this->value[$key])) {
            return new self($this->value[$key]);
        } elseif (is_object($this->value) && property_exists($this->value, $key)) {
            return new self($this->value->$key);
        } else {
            return new self(null);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset)
    {
        return $this->get($offset)->get() !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        if (is_array($this->value)) {
            reset($this->value);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return is_array($this->value) ? new self(current($this->value)) : new self();
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return is_array($this->value) ? key($this->value) : null;
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        if (is_array($this->value)) {
            next($this->value);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return is_array($this->value) ? false !== current($this->value) : false;
    }
}
