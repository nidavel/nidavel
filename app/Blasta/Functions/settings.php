<?php

require_once base_path('/app/Blasta/Classes/Settings.php');
require_once base_path('/app/Blasta/Classes/SettingsForm.php');

/**
 * Get settings instance
 */
function getSettings()
{
    return Settings::getInstance();
}

/**
 * A cleaner way of returning values for settings using dot notation
 */
function settings(string $mode, string $settings, string $value = '')
{
    $theSettings    = Settings::getInstance();
    $allSettings    = $theSettings->all();
    $settings       = explode('.', $settings);
    $key            = $settings[0];
    $setting        = isset($settings[1]) ? $settings[1] : null;

    switch (strtolower($mode)) {
        case 'r':
            if (!empty($allSettings[$key][$setting])) {
                return $theSettings->get($key, $setting);
            } else {
                return $value;
            }
        case 'w':
            $theSettings->add($key, [$setting => $value]);
            break;
        case 'd':
            $theSettings->clear($key);
            break;
        default:
            exit("Mode '$mode' not recognized");
    }
}

/**
 * Adds settings form to the settings page
 */
function registerSettingsForm(string $title, string $key, string $resource)
{
    $form = SettingsForm::getInstance();
    $form->register($title, $key, $resource);
}

/**
 * Gets all settings forms
 */
function allSettingsForms(): array
{
    $forms = SettingsForm::getInstance();
    return $forms->all();
}
