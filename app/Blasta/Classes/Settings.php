<?php

class Settings
{
    private static $instance = null;

    private static array $settings = [];
    private static string $json;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new Settings;

            static::$json = base_path("/app/Blasta/settings.json");
            // static::$json = '../settings.json';
            static::$instance->refresh();
        }

        return static::$instance;
    }

    public function add(string $key, array $settings)
    {
        foreach ($settings as $setting => $value) {
            static::$settings[$key][$setting] = $value;
        }        

        $this->write();
        $this->refresh();
    }

    public function update(string $key, string $setting, $value)
    {
        if (isset(static::$settings[$key][$setting])) {
            static::$settings[$key][$setting] = $value;
        }

        $this->write();
        $this->refresh();
    }

    public function remove(string $key, string ...$settings)
    {
        foreach ($settings as $setting) {
            unset(static::$settings[$key][$setting]);
        }

        $this->write();
        $this->refresh();
    }

    public function get(string $key, string $setting)
    {
        return static::$settings[$key][$setting];
    }

    public function list(string $key): array
    {
        return static::$settings[$key];
    }

    public function all(): array
    {
        return static::$settings;
    }

    public function clear(string $key)
    {
        unset(static::$settings[$key]);

        $this->write();
        $this->refresh();
    }

    private function write()
    {
        file_put_contents(static::$json, json_encode(static::$settings));
    }

    private function refresh()
    {
        $json = file_get_contents(static::$json);
        static::$settings = json_decode($json, true);
    }
}
