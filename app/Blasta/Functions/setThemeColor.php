<?php

/**
 * Sets the theme color
 */
function setThemeColor(string $color)
{
    settings('w', 'general.theme_color', $color);
}
