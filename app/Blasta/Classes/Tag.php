<?php

require_once base_path('/app/Blasta/Classes/Set.php');

class Tag
{
    private static $instance = null;
    private static $json;
    private static Set $tags;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new Tag;
            static::$tags = new Set();
            static::$json = base_path("/app/Blasta/tags.json");
            static::$instance->refresh();
        }
        
        return static::$instance;
    }

    /**
     * Returns all tags
     */
    public function all()
    {
        $this->refresh();

        return static::$tags->getItems();
    }

    /**
     * Adds tag(s) to the tags
     */
    public function add(string ...$tags)
    {
        static::$tags->add(...$tags);
        $this->write();
        $this->refresh();
    }

    /**
     * Removes tag(s) from the tags
     */
    public function remove(string ...$tags)
    {
        static::$tags->remove(...$tags);
        $this->write();
        $this->refresh();
    }

    /**
     * Deletes every tag
     */
    public function clear()
    {
        static::$tags->clear();
        $this->write();
        $this->refresh();
    }

    /**
     * Converts given meta tags to array
     */
    public function parse(?string $meta = null)
    {
        if ($meta === null) {
            return;
        }
        
        $tags = explode(',', $meta);

        $index = 0;
        foreach ($tags as $tag) {
            $tags[$index++] = trim($tag);
        }

        return $tags;
    }

    /**
     * Stores the tags to file
     */
    private function write()
    {
        file_put_contents(static::$json, json_encode(static::$tags->getItems()));
    }

    /**
     * Refreshes the tags variable
     */
    private function refresh()
    {
        $json = file_get_contents(static::$json);
        $tags = json_decode($json, true);
        static::$tags->clear();
        static::$tags->add(...$tags);
    }
}
