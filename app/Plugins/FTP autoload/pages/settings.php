<?php
$upload_on_post_publish = !empty(settings('r', 'ftpa.upload_on_post_publish'))
? 'checked'
: '';

$passive = !empty(settings('r', 'ftpa.passive'))
? 'checked'
: '';

$port = !empty(settings('r', 'ftpa.port'))
    ? settings('r', 'ftpa.port')
    : 21;

$timeout = !empty(settings('r', 'ftpa.timeout'))
    ? settings('r', 'ftpa.timeout')
    : 90;

$publicDir = !empty(settings('r', 'ftpa.pub_dir'))
    ? settings('r', 'ftpa.pub_dir')
    : '/public_html';
?>

<style>
.generate-btn {
    display: inline-block;
    background-color: none;
    color: rgb(59 130 246);;
    border: 1px solid rgb(59 130 246);;
    border-radius: 5px;
    transition: ease-in-out 500ms;
}

.generate-btn:hover {
    opacity: 0.8;
}
</style>

<div class="italic text-sm">
    <p>Please note:<br>
        <ul>
            <li>FTP autoload requires internet connection to work fully.</li>
        </ul>
    </p>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>FTP hostname</div>
        <input class="border border-gray-400 rounded-lg w-full" type="text" name="host" id="" placeholder="ftp.example.com" value="<?= settings('r', 'ftpa.host') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>FTP public directory</div>
        <input class="border border-gray-400 rounded-lg w-full" type="text" name="pub_dir" id="" value="<?= $publicDir ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>FTP port</div>
        <input class="border border-gray-400 rounded-lg w-full" type="number" min="1" name="port" id="" value="<?= $port ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>FTP username</div>
        <input class="border border-gray-400 rounded-lg w-full" type="text" name="username" id="" value="<?= settings('r', 'ftpa.username') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>FTP password</div>
        <input class="border border-gray-400 rounded-lg w-full" type="password" name="password" id="" value="<?= settings('r', 'ftpa.password') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>FTP connection timeout</div>
        <input class="border border-gray-400 rounded-lg w-full" type="number" min="1" name="timeout" id="" value="<?= $timeout ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Passive mode</div>
        <input class="border border-gray-400 rounded-lg" type="checkbox" <?= $passive ?> name="passive" id="">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Upload on post publish</div>
        <input class="border border-gray-400 rounded-lg" type="checkbox" <?= $upload_on_post_publish ?> name="upload_on_post_publish" id="">
    </label>
</div>

<div>
    <a href="/ftpa/upload-site" class="px-4 py-1 generate-btn">Upload site</a>
</div>
