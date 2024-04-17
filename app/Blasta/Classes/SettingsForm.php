<?php

class SettingsForm
{
    private static $instance = null;
    private static $forms;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance   = new SettingsForm;
            static::$forms      = [];
        }
        
        return static::$instance;
    }

    /**
     * Returns all registered settings forms
     */
    public function all()
    {
        return static::$forms;
    }

    /**
     * Adds a form to the settings page
     */
    public function register(string $title, string $key, string $resource)
    {
        $form[$title]  = [
            'key'       => $key,
            'resource'  => $resource
        ];

        static::$forms = [...static::$forms, ...$form];
    }
}
