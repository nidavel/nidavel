<?php

require_once base_path('/app/Blasta/Classes/Settings.php');

function addMenu(string $title, string $url, ?string $target = null)
{
    $settings = Settings::getInstance();
    $settings->add('menu', [
        $title => [
            'url'       => $url,
            'target'    => $target
        ]
    ]);
}

function getMenuList()
{
    $settings = Settings::getInstance();
    return $settings->list('menu') ?? [];
}

function removeMenu(string $title)
{
    $settings = Settings::getInstance();
    $settings->remove('menu', $title);
}

function clearMenu()
{
    $settings = Settings::getInstance();
    // $settings->clear('menu');
    $settings->initialize('menu', []);
    // $settings->add('menu', []);
}

function getMenu()
{
    $newMenu = [];
    $menu = getMenuList();

    foreach ($menu as $title => $props) {
        if (substr($props['url'], 0, 4) === 'http') {
            $newMenu[] = $props['target'] == null
                ? '<a aria-label="'.ucfirst($title).'" title="'.ucfirst($title).'" href="'.$props['url'].'">'.ucfirst($title).'</a>'
                : '<a aria-label="'.ucfirst($title).'" title="'.ucfirst($title).'" href="'.$props['url'].'" target="'.$props['target'].'">'.ucfirst($title).'</a>';
            
            continue;
        }

        $newMenu[] = $props['target'] == null
            ? '<a aria-label="'.ucfirst($title).'" title="'.ucfirst($title).'" href="'.exportLink($props['url']).'">'.ucfirst($title).'</a>'
            : '<a aria-label="'.ucfirst($title).'" title="'.ucfirst($title).'" href="'.exportLink($props['url']).'" target="'.$props['target'].'">'.ucfirst($title).'</a>';
    }

    return $newMenu;
}
