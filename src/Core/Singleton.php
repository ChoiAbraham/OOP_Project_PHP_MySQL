<?php

namespace App\Core;

/**
 * Singleton Design Pattern
 *
 * Intent: Lets you ensure that a class has only one instance, while providing a
 * global access point to this instance.
 */

class Singleton
{
    /**
     * singleton's instance almost always resides inside a static field.
     * In this case, array, where each subclass of the Singleton stores its own instance.
     */
    private static $instances = [];

    /**
     * never public. However neither private (subclass).
     */
    protected function __construct()
    {
    }

    /**
     * method to get the Singleton's instance.
     */
    public static function getInstance()
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            //"static" means "the name of the current class"
            self::$instances[$subclass] = new static;
        }
        return self::$instances[$subclass];
    }

    public static function getInstanceRepo($db)
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            //"static" means "the name of the current class"
            self::$instances[$subclass] = new static($db);
        }
        return self::$instances[$subclass];
    }
}
