<?php
use App\Http\Controllers\PageController;
$currHomepage = settings('r', 'general.homepage');
$pageController = new PageController;
$pages = $pageController->listForSettings();

$update_exports_on_post_publish =
    !empty(settings('r', 'general.update_exports_on_post_publish'))
        ? 'checked'
        : '';

$protocol = settings('r', 'general.protocol');
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
        <div>Update exports on post publish </div>
        <input class="border border-gray-400 rounded-lg" type="checkbox" <?= $update_exports_on_post_publish ?> name="update_exports_on_post_publish" id="">
    </label>
</div>
