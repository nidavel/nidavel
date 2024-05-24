<?php

use Nidavel\Feed\Classes\FeedType;

$feed = FeedType::getInstance();
$feedType = settings('r', 'feed.feed_type');
?>

<style>
.feed-listbox {
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
        <div>Feed type</div>
        <select class="border border-gray-400 rounded-lg w-full" name="feed_type" id="">
            <option <?= $feedType === 'Feed' ? 'selected' : '' ?> value="Feed">Default</option>
            <option <?= $feedType === 'Rss' ? 'selected' : '' ?> value="Rss">RSS</option>
            <option <?= $feedType === 'Atom' ? 'selected' : '' ?> value="Atom">ATOM</option>
        </select>
    </label>
</div>

<div class="flex flex-col gap-2">
    <details>
        <summary>
        View feed
        </summary>
        <div class="feed-listbox border rounded p-4 text-sm">
        <pre class="w-full">
<?= htmlentities($feed::view()) ?>
        </pre>
        </div>
    </details>
</div>

<div>
    <a href="/feed/generate" class="px-4 py-2 generate-btn">Generate</a>
</div>
