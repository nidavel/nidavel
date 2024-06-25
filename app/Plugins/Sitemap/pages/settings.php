<?php
use Nidavel\Sitemap\Classes\Sitemap;

$sitemap = Sitemap::getInstance();
$sitemapType = settings('r', 'sitemap.sitemap_type');
$createRobots = settings('r', 'sitemap.create_robots');
$stripHtmlExtension = !empty(settings('r', 'sitemap.strip_html_extension'))
    ? 'checked'
    : '';
?>

<style>
.sitemap-listbox {
    width: 50vw;
    height: 16rem;
    min-height: 16rem;
    max-height: 18rem;
    overflow: auto;
    background-color: rgba(0,0,0, 80%);
    color: #ffffff;
}

.generate-btn {
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

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Sitemap type</div>
        <select class="border border-gray-400 rounded-lg w-full" name="sitemap_type" id="">
            <option <?= $sitemapType === 'xml' ? 'selected' : '' ?> value="xml">XML</option>
            <option <?= $sitemapType === 'text' ? 'selected' : '' ?> value="text">Text</option>
        </select>
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Strip .html extension</div>
        <input class="border border-gray-400 rounded-lg" type="checkbox" <?= $stripHtmlExtension ?> value="checked" name="strip_html_extension" id="">
    </label>
</div>

<div class="w-64">
    <label class="flex flex-col gap-2">
        <div>Create robots.txt file</div>
        <input class="border border-gray-400 rounded-lg" type="checkbox" <?= $createRobots ?> value="checked" name="create_robots" id="">
    </label>
</div>

<div class="w-64 italic text-sm">
    The sitemap and robots file is saved in my_exports root folder.
</div>

<!-- ***************************** -->

<div class="flex flex-col gap-2">
    <details>
        <summary>
        View mapped URLs
        </summary>
        <div class="shadow" style="width:50vw;">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Url</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Ignore URL</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                <?php
                $mappedUrls = $sitemap::getMappedUrls();
                if (!empty($mappedUrls)) {
                    foreach ($mappedUrls as $mappedUrl) {
                ?>
                    <tr class="odd:bg-white even:bg-gray-100">
                        <td class="px-6 py-4"><?= $mappedUrl ?></td>
                        <td class="px-6 py-4 text-red-500">
                            <a href="/sitemap/ignore-url?url=<?=$mappedUrl?>">
                                Ignore
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                }
                ?>
            </tbody>
        </table>
        </div>
    </details>
</div>

<div class="flex flex-col gap-2">
    <details>
        <summary>
        View ignored URLs
        </summary>
        <div class="shadow" style="width:50vw;">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Url</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Allow URL</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                <?php
                $ignoredUrls = $sitemap::getIgnored();
                if (!empty($ignoredUrls)) {
                    foreach ($ignoredUrls as $ignoredUrl) {
                        if ($ignoredUrl == "") continue;
                ?>
                    <tr class="odd:bg-white even:bg-gray-100">
                        <td class="px-6 py-4"><?= $ignoredUrl ?></td>
                        <td class="px-6 py-4 text-green-500">
                            <a href="/sitemap/unignore-url?url=<?=$ignoredUrl?>">
                                Allow
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                }
                ?>
            </tbody>
        </table>
        </div>
    </details>
</div>

<div class="flex flex-col gap-2">
    <details>
        <summary>
        View sitemap
        </summary>
        <div class="sitemap-listbox border rounded p-4 text-sm">
        <pre class="w-full">
<?= htmlentities($sitemap::view()) ?>
        </pre>
        </div>
    </details>
</div>

<div>
    <a href="/sitemap/generate" class="px-4 py-2 generate-btn">Generate</a>
</div>
<?php
