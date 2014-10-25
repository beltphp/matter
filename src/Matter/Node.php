<?php
namespace Belt\Matter;

/**
 * @author Ramon Kleiss <ramonkleiss@gmail.com>
 */
class Node
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
}
