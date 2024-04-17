<?php

class PostHead
{
    private static $instance = null;
    private static $meta = "\n";

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance   = new PostHead;
            static::$meta       = "\n";
        }
        
        return static::$instance;
    }

    /**
     * Returns attached post head meta
     */
    static function get()
    {
        return static::$meta;
    }

    /**
     * Appends a meta to the global meta
     */
    static function append(string $meta)
    {
        static::$meta .= "$meta\n";
    }
}
