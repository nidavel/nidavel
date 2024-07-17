<?php

require_once base_path('app/Blasta/Functions/settings.php');

/**
 * Sets the theme color
 */
function setThemeColor(string $color)
{
    settings('w', 'general.theme_color', $color);
}

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
 * This function returns the names of all customized styles
 */
function getCustomizedStyleNames()
{
    $customizedStyles = settings('r', 'general.customized_style_names');
    $customizedStyles = explode("'", $customizedStyles);
    array_shift($customizedStyles);

    return $customizedStyles;
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

/**
 * This function checks if a given style name 
 * is added to the customized list
 */
function isStyleCustomized(string $name)
{
    $customizedStyles = settings('r', 'general.customized_style_names');

    if (strpos($customizedStyles, $name) > 0) {
        return true;;
    }

    return false;
}

/**
 * This function checks if a particular selector is active
 * in an active customized style
 */
function isSelectorCustomized(string $input)
{
    $value = explode("'", $input);
    $name = $value[0];
    $selector = $value[1];

    if (isStyleCustomized($name) === false) {
        return false;
    }

    $styleFile = base_path("app/CustomizedStyles/$name");
    
    if (!file_exists($styleFile)) {
        return false;
    }

    $style = file_get_contents(base_path("app/CustomizedStyles/$name"));

    if (strpos($style, $selector)) {
        return true;
    }

    return false;
}

/**
 * This function checks if a particular property is active
 * in an active selector in an active customized style
 */
function isPropertyCustomized(string $input)
{
    $value = explode("'", $input);
    $name = $value[0];
    $selector = $value[1];
    $property = $value[2];
    $falsePositives = [
        'color'
    ];

    if (isStyleCustomized($name) === false) {
        return false;
    }

    $styleFile = base_path("app/CustomizedStyles/$name");

    if (!file_exists($styleFile)) {
        return false;
    }

    $style = file_get_contents($styleFile);

    if (strpos($style, $selector)) {
        $fp = fopen($styleFile, 'r');
        foreach (readFileLine($fp) as $line) {
            $idx = strpos($line, $selector);
            if ($idx < 1) {
                continue;
            } else {
                $content = '';

                if (in_array($property, $falsePositives)) {
                    $content = substr($line, strpos($line, $property) - 1, strlen($property) + 1);
                    if ($content[0] === '-') {
                        $content = substr($line, strpos($line, $property) - 1);
                        while ($content[0] === '-' && strlen($content) > 0) {
                            $content = substr($line, strpos($content, $property) - 1);
                            if ($content[0] !== '-') {
                                $content = substr($line, strpos($content, $property) - 1, strlen($property) + 1);
                                break;
                            }
                        }
                    }
                    $content = ltrim($content, $content[0]);
                } else {
                    $content = substr($line, strpos($line, $property), strlen($property));
                }

                if ($content === $property) {
                    fclose($fp);
                    return true;
                }
            }
        }

        fclose($fp);
    }

    return false;
}

/**
 * This function gets the value of a given selector in a customized style
 */
function getCustomizedSelectorValue(string $input)
{
    $value = null;
    $input = explode("'", $input);
    $styleFile = base_path('app/CustomizedStyles/'.$input[0]);
    $selector = $input[1];

    if (!file_exists($styleFile)) {
        return null;
    }

    $matchx = null;
    $content = null;
    $fp = fopen($styleFile, 'r');
    foreach (readFileLine($fp) as $line) {
        $matchx = getSelectorValue($line, $selector);
        if (is_null($matchx)) {
            continue;
        } else {
            break;
        }
    }

    fclose($fp);
    if (!empty($matchx)) {
        $value = str_replace('--color:', '', $matchx);
    }

    return "$value";
}

/**
 * This function returns the specified property and value of a given selector
 */
function getSelectorValue(string $line, string $selector)
{
    $idx = strpos($line, $selector);
    $selectorValue = '';

    if ($idx < 1) {
        return null;
    } else {
        $values = explode(';', $line);
        $selectorValue = substr($values[0], strpos($values[0], '--color'));
        return !empty($selectorValue) ? $selectorValue : null;
    }
}

/**
 * This function extracts the red value in an rgba string
 */
function getRedFromPropertyValue(string $input)
{
    $val    = stripRGBText($input);
    $val    = explode(',', $val);
    return  $val[0];
}

/**
 * This function extracts the green value in an rgba string
 */
function getGreenFromPropertyValue(string $input)
{
    $val    = stripRGBText($input);
    $val    = explode(',', $val);
    return  $val[1];
}

/**
 * This function extracts the blue value in an rgba string
 */
function getBlueFromPropertyValue(string $input)
{
    $val    = stripRGBText($input);
    $val    = explode(',', $val);
    return  $val[2];
}

/**
 * This function extracts the alpha value in an rgba string
 */
function getAlphaFromPropertyValue(string $input)
{
    $val    = stripRGBText($input);
    $val    = explode(',', $val);

    return  $val[3] ?? 1;
}

/**
 * This funtion takes a rgb or rgba string and returns the values within
 * the parentheses
 */
function stripRGBText(string $input)
{
    $val    = trim($input);
    $val    = ltrim($val, 'rgba(');
    $val    = ltrim($val, 'rgb(');
    $val    = rtrim($val, ')');

    return $val;
}

/**
 * This function converts a rgb string to a rgba string
 */
function parseRGBA($rgba)
{
    if (substr(trim($rgba), 0, 4) === 'rgba') {
        return $rgba;
    }

    $rgba = str_replace('rgb', 'rgba', $rgba);
    $rgba = str_replace('rgbaa', 'rgba', $rgba);
    $rgba = str_replace(')', ', 1)', $rgba);

    return $rgba;
}

function readFileLine($fp)
{
    while (!feof($fp)) {
        yield fgets($fp);
    }
}
