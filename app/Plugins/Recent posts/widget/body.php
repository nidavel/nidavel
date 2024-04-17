<?php

use App\Models\Post;

$postCount = !empty(getWidgetOption(getCurrentWidgetArea(), 'Recent posts', 'posts_count'))
    ? getWidgetOption(getCurrentWidgetArea(), 'Recent posts', 'posts_count')
    : 3;

$posts = Post::where('post_type', 'post')
    ->where('status', 'published')
    ->latest()
    ->orderBy('id', 'DESC')
    ->limit($postCount)
    ->offset(0)
    ->get();
?>

<div>
    <ol class="widget-list">
    <?php
    foreach ($posts as $post) {
        $link = exportLink("/posts/$post->link");
        $recentPost = '<li class="widget-list-item">';
        $recentPost .= "<a class=\"widget-link\" href=\"$link\">$post->title</a>";
        $recentPost .= '</li>';
        echo $recentPost;
    }
    ?>
    </ol>
</div>
