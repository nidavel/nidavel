<?php
use App\Http\Controllers\PageController;
$currHomepage = settings('r', 'general.homepage');
$pageController = new PageController;
$pages = $pageController->listForSettings();

$export_homepage_on_post_publish =
    !empty(settings('r', 'general.export_homepage_on_post_publish'))
        ? 'checked'
        : '';

$protocol = settings('r', 'general.protocol');

$timezones = getTimezones();
$appTimezone = !empty(settings('r', 'general.timezone'))
    ? settings('r', 'general.timezone')
    : 'UTC';

$locales = getLocales();
$appLocale = !empty(settings('r', 'general.locale'))
    ? settings('r', 'general.locale')
    : 'en_US';
?>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>App name</div>
        <input class="border border-gray-400 rounded-lg w-full" type="text" name="name" id="" placeholder="App name" value="<?= settings('r', 'general.name') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Homepage</div>
        <select class="border border-gray-400 rounded-lg w-full" name="homepage" id="">
            <option <?= $currHomepage === 'default' ? 'selected' : '' ?> value="default">Default</option>
            <?php
            if (!is_null($pages)) {
                foreach ($pages as $page) {
                    $option = '<option value="'.$page['link'].'"';
                    $option .= $currHomepage == $page['link'] ? 'selected' : '';
                    $option .= '>'.$page['title'].'</option>';
                    echo $option;
                }
            }
            ?>
        </select>
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Query limit</div>
        <input class="border border-gray-400 rounded-lg w-full" type="number" name="query_limit" id=""  value="<?= settings('r', 'general.query_limit') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Protocol</div>
        <select class="border border-gray-400 rounded-lg w-full" name="protocol" id="">
            <option <?= $protocol === 'http' ? 'selected' : '' ?> value="http">HTTP</option>
            <option <?= $protocol === 'https' ? 'selected' : '' ?> value="https">HTTPS</option>
        </select>
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Domain (Fill this value only when you have a registered domain)</div>
        <input class="border border-gray-400 rounded-lg w-full" type="text" name="domain" id="" placeholder="example.com" value="<?= settings('r', 'general.domain') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Property ID (Fill this value only when you have a Nidavel property ID)</div>
        <input class="border border-gray-400 rounded-lg w-full" type="text" name="property_id" id="" value="<?= settings('r', 'general.property_id') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Logo URL</div>
        <input class="border border-gray-400 rounded-lg w-full" type="text" name="logo_url" id="" value="<?= settings('r', 'general.logo_url') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Language / Locale</div>
        <select class="border border-gray-400 rounded-lg w-full" name="language" id="">
        <?php
            foreach ($locales as $locale => $localeName) {
                ?>
                <option <?= $appLocale === $locale ? 'selected' : '' ?> value="<?=$locale?>"><?=$localeName?></option>
            <?php
            }
            ?>
        </select>
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Timezone</div>
        <select class="border border-gray-400 rounded-lg w-full" name="timezone" id="">
            <?php
            foreach ($timezones as $timezone) {
                ?>
                <option <?= $appTimezone === $timezone ? 'selected' : '' ?> value="<?=$timezone?>"><?=$timezone?></option>
            <?php
            }
            ?>
        </select>
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Export homepage on post publish </div>
        <input class="border border-gray-400 rounded-lg" type="checkbox" <?= $export_homepage_on_post_publish ?> name="export_homepage_on_post_publish" id="">
    </label>
</div>
