<?php

class Head
{
    private static $instance = null;
    private static $node = "";

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance   = new Head;
            static::$node       = "\n";
        }
        
        return static::$instance;
    }

    /**
     * Returns attached post head meta
     */
    static function get()
    {
        return static::$node;
    }

    /**
     * Appends a meta to the global meta
     */
    static function append(string $node)
    {
        static::$node .= "$node\n";
    }
}
