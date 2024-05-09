<?php

require_once base_path('app/Blasta/Functions/settings.php');

/**
 * This function is used to add customizable selectors
 * for custom editing
 */
function customizeSelectors(string|null $name = null, array|string|null $selectors = null)
{
    static $allSelectors;

    if ($name === null && $selectors == null) {
        return $allSelectors;
    }

    $allowedProperties = [
        'color',
        'background-color',
        'border-color'
    ];

    $tempSelectors = [];
    foreach ($selectors as $selector => $properties) {
        if (empty($selector[0])) {
            $tempSelectors[$properties] = $allowedProperties;
            continue;
        } else {
            $tempProperties = [];
            if (is_array($properties)) {
                foreach ($properties as $property) {
                    if (!in_array($property, $allowedProperties)) {
                        continue;
                    }
                    $tempProperties[] = $property;
                }
            }
            else if (is_string($properties)) {
                if (!in_array($properties, $allowedProperties)) {
                    continue;
                }
                $tempProperties[] = $properties;
            }

            $tempSelectors[$selector] = $tempProperties;
        }
    }

    $allSelectors[$name] = $tempSelectors;

    return $allSelectors;
}

/**
 * This function gets all the customizable selectors
 */
function getCustomizeableSelectors()
{
    return customizeSelectors();
}

/**
 * Adds a style name to the list of customized styles
 */
function addCustomizedStyleName(string $name)
{
    $customizedStyles = settings('r', 'general.customized_style_names');

    if (!isStyleCustomized($name)) {
        settings('a', 'general.customized_style_names', "'$name");
    }

    return true;
}

/**
 * Removes a style name from the list of customized styles
 */
function removeCustomizedStyleName(string $name)
{
    $customizedStyles = settings('r', 'general.customized_style_names');

    if (empty($customizedStyles)) {
        return;
    }

    $customizedStyles = str_replace("'$name", '', $customizedStyles);
        
    settings('w', 'general.customized_style_names', $customizedStyles);

    return true;
}

function isStyleCustomized(string $name)
{
    $customizedStyles = settings('r', 'general.customized_style_names');

    if (strpos($customizedStyles, $name) > 0) {
        return true;;
    }

    return false;
}

function getCustomizedPropertyValue(string $input)
{
    $value = null;
    $input = explode("'", $input);
    $styleFile = base_path('app/Blasta/CustomizedStyles/'.$input[0]);
    $selector = $input[1];
    $property = $input[2];

    if (!file_exists($styleFile)) {
        return $value;
    }

    $matchx = '';
    $fp = fopen($styleFile, 'r');
    foreach (readFileLine($fp) as $line) {
        $idx = strpos($line, $selector);
        if ($idx < 1) {
            continue;
        } else {
            $propIdx = strpos($line, $property);
            $matchx = substr($line, $propIdx, strpos($line, ';') - $propIdx);
            break;
        }
    }

    fclose($fp);
    if (!empty($matchx)) {
        $value = ltrim($matchx, "$property:");
        $value = rtrim($value, ';');
    }

    return $value;
}

function readFileLine($fp)
{
    while (!feof($fp)) {
        yield fgets($fp);
    }
}
