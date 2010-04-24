<?php

namespace System;

class NObject
    implements IObject
{
    public static function staticEquals($object1, $object2)
    {
        return $object1->equals($object2);
    }

    public static function referenceEquals($object1, $object2)
    {
        return NBoolean::get($object1 === $object2);
    }

    public function equals($object)
    {
        return NBoolean::get($this === $object);
    }

    /**
     *
     * @return NString
     */
    public function getHashCode()
    {
        return NString::get(spl_object_hash($this));
    }

    /**
     * Gets the Type of the current instance as an NString.
     *
     * @return NString
     */
    public function getType()
    {
        return NString::get(get_class($this));
    }

    public function memberwiseClone()
    {
        // TODO This should be replaced with a custom memberwise
        // clone that will always do a shallow copy.  Right now it'll
        // call the __clone() method if it exists.
        return clone $this;
    }

    /**
     * Returns an NString that represents the current NObject.
     *
     * @return NString
     */
    public function toString()
    {
        return NString::get(get_class($this));
    }

    /**
     * Returns a PHP string that represents the current NObject.
     *
     * @return string
     */
    public function __toString()
    {
        // This wraps the magic __toString to our toString method.
        return $this->toString()->string();
    }

    public function __call($name, $arguments)
    {
        return self::methodDispatcher($this, $name, $arguments);
    }

    private static $methodTable = array();

    /**
     * Dispatches an extension method for $instance with the given $name and $arguments.
     *
     * This method will examine the entire inheritance chain for a suitable
     * method.
     *
     * @param mixed $instance
     * @param string $name
     * @param array $arguments
     * @return mixed The result of the extension method.
     *
     * @throws MissingMethodException if no extension method exists.
     */
    public static function methodDispatcher($instance, $name, $arguments)
    {        
        $table =& self::$methodTable;        
        $class = get_class($instance);
        do
        {
            if (array_key_exists($class, $table) && array_key_exists($name, $table[$class]))
                break;

            $class = get_parent_class($class);
        }
        while ($class !== false);

        if ($class === false)
            throw new MissingMethodException();

        $func = $table[$class][$name];
        array_unshift($arguments, $instance);

        return call_user_func_array($func, $arguments);
    }

    /**
     * Dynamically add a method to this class.  All instances will immediately
     * be able to call it.
     *
     * @param string $methodName
     * @param string $method
     * @param string $class Optional class override.  If this is passed, the
     * method will be attached to this class instead of the called class.
     */
    public static function addMethod($methodName, $method, $class = null)
    {
        if (!$class) $class = get_called_class();
                
        $table =& self::$methodTable;
        if (!array_key_exists($class, $table))
        {
            $table[$class] = array();
        }

        $table[$class][$methodName] = $method;
    }        
}


