<?php
$push_on_post_publish = !empty(settings('r', 'github_autopush.push_on_post_publish'))
    ? 'checked'
    : '';
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
            <li>GitHub autopush requires internet connection to work fully.</li>
            <li>You also need to have git installed locally in your computer.</li>
            <li>And a valid GitHub repository is required.</li>
        </ul>
    </p>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Repository (username/repository.git)</div>
        <input class="border border-gray-400 rounded-lg w-full" type="text" name="repository" id="" placeholder="username/repository.git" value="<?= settings('r', 'github_autopush.repository') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Personal authentication token</div>
        <input class="border border-gray-400 rounded-lg w-full" type="text" name="pat" id="" placeholder="" value="<?= settings('r', 'github_autopush.pat') ?>">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Commit and push on post publish </div>
        <input class="border border-gray-400 rounded-lg" type="checkbox" <?= $push_on_post_publish ?> name="push_on_post_publish" id="">
    </label>
</div>

<div>
    <a href="/github-autopush/init" class="px-4 py-1 generate-btn">Init</a>
</div>

<div>
    <a href="/github-autopush/push" class="px-4 py-1 generate-btn">Push</a>
</div>
