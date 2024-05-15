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

function isSelectorCustomized(string $input)
{
    $value = explode("'", $input);
    $name = $value[0];
    $selector = $value[1];

    if (!isStyleCustomized($name)) {
        return false;
    }

    $styleFile = base_path("app/Blasta/Styles/$name");
    $style = file_get_contents(base_path("app/Blasta/CustomizedStyles/$name"));

    if (strpos($style, $selector)) {
        return true;
    }

    return false;
}

function isPropertyCustomized(string $input)
{
    $value = explode("'", $input);
    $name = $value[0];
    $selector = $value[1];
    $property = $value[2];
    $falsePositives = [
        'color'
    ];

    if (!isStyleCustomized($name)) {
        return false;
    }

    $styleFile = base_path("app/Blasta/CustomizedStyles/$name");
    $style = file_get_contents(base_path("app/Blasta/CustomizedStyles/$name"));

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
                        $content = '';
                        continue;
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

function getCustomizedPropertyValue(string $input)
{
    $value = null;
    $input = explode("'", $input);
    $styleFile = base_path('app/Blasta/CustomizedStyles/'.$input[0]);
    $selector = $input[1];
    $property = $input[2];

    if (!file_exists($styleFile)) {
        return null;
    }

    $matchx = null;
    $content = null;
    $fp = fopen($styleFile, 'r');
    foreach (readFileLine($fp) as $line) {
        $matchx = getPropertyAndValue($line, $selector, $property);
        if (is_null($matchx)) {
            continue;
        } else {
            break;
        }
    }

    fclose($fp);
    if (!empty($matchx)) {
        $value = ltrim($matchx, $property.':');
        $value = rtrim($value, ';');
    }

    return "r$value";
}

function readFileLine($fp)
{
    while (!feof($fp)) {
        yield fgets($fp);
    }
}

function getPropertyAndValue(string $line, string $selector, string $property)
{
    $propIdx = null;
    $content = null;
    $matchx = '';    
    $idx = strpos($line, $selector);
    $falsePositives = [
        'color'
    ];

    if ($idx < 1) {
        return null;
    } else {
        if (in_array($property, $falsePositives)) {
            $content = substr($line, strpos($line, $property) - 1);

            if ($content[0] === '-') {
                $content = substr($content, strpos($content, ";$property"));
            }
            
            $content = ltrim($content, $content[0]);
            $propIdx = strpos($line, $content);
        } else {
            $propIdx = strpos($line, $property);
            $content = substr($line, $propIdx);
        }
        
        $matchx = substr($content, 0, strpos($content, ';'));

        return $matchx;
    }
}

function getRedFromPropertyValue(string $input)
{
    $val    = stripRGBText($input);
    $val    = explode(',', $val);
    return  $val[0];
}

function getGreenFromPropertyValue(string $input)
{
    $val    = stripRGBText($input);
    $val    = explode(',', $val);
    return  $val[1];
}

function getBlueFromPropertyValue(string $input)
{
    $val    = stripRGBText($input);
    $val    = explode(',', $val);
    return  $val[2];
}

function getAlphaFromPropertyValue(string $input)
{
    $val    = stripRGBText($input);
    $val    = explode(',', $val);
    return  $val[3];
}

function stripRGBText(string $input)
{
    $val    = ltrim($input, 'rgba(');
    $val    = rtrim($val, '%)');

    return $val;
}
