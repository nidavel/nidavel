<?php

class Body
{
    private static $instance    = null;
    private static $prepends    = "\n";
    private static $appends     = "\n";

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance   = new Body;
            static::$prepends    = "\n";
            static::$appends     = "\n";
        }
        
        return static::$instance;
    }

    /**
     * Returns prepended body entities
     */
    static function getPrepends()
    {
        return static::$prepends;
    }

    /**
     * Returns appended body entities
     */
    static function getAppends()
    {
        return static::$appends;
    }

    /**
     * Prepends an entity to the body
     */
    static function prepend(string $prepend)
    {
        static::$prepends .= "$prepend\n";
    }

    /**
     * Appends an entity to the body
     */
    static function append(string $append)
    {
        static::$appends .= "$append\n";
    }
}
