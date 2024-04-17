<?php

class Widget
{
    private static $instance = null;
    private static $widgets;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance   = new Widget;
            static::$widgets    = [];
        }
        
        return static::$instance;
    }

    /**
     * Returns all widgets
     */
    public function all()
    {
        return static::$widgets;
    }

    /**
     * Returns all active widgets
     */
    public function getActive(bool $assoc = false)
    {
        return json_decode(file_get_contents(base_path('/app/Blasta/active_widgets.json')), $assoc);
    }

    /**
     * Adds a widget to the widgets
     */
    public function register(string $name, string $body, ?array $options = null)
    {
        $widget[$name]  = [
            'body'      => $body,
            'options'   => $options
        ];

        static::$widgets = [...static::$widgets, ...$widget];
    }

    /**
     * Returns the widget and props by name
     */
    public function getWidget(string $widgetName)
    {
        if (!empty(static::$widgets[$widgetName])) {
            return static::$widgets[$widgetName];
        }
        
        return null;
    }

    /**
     * Removes a widget from the widgets
     */
    public function remove(string $widgetName)
    {
        $widgets = $this->all();
        unset($widgets[$widgetName]);
        static::$widgets = $widgets;
    }

    /**
     * Deletes every widget
     */
    public function clear()
    {
        static::$widgets = [];
    }
}
