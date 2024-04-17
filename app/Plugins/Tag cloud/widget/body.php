<?php

require_once base_path('app/Blasta/Classes/Tag.php');

$tags = Tag::getInstance();
$tags = $tags->all();
$newTags = [];
$count = count($tags);
$tagCount = getWidgetOption(getCurrentWidgetArea(), 'Tag cloud', 'tags_count');

while (count($newTags) < $count) {
    $i = rand(0, $count - 1);
    if (in_array($tags[$i], $newTags)) {
        continue;
    }
    $newTags[] = $tags[$i];
}

$tags = $newTags;
?>

<style>
.pill {
    padding: 0.5rem 1rem;
    border-radius: 15px;
    display: inline-flex;
    justify-self: start;
    margin: 0px 5px 5px 0px;
    background-color: rgba(50, 50, 50, 5%);
}
</style>

<div>
    <?php
    if (!empty($tags)) {
        for ($x = 0; $x < $tagCount; $x++) {
            $link = exportLink('/tags/'.$tags[$x]);
            $output = "<a href=\"$link\" class=\"widget-link\">";
            $output .= '<span class="pill">';
            $output .= $tags[$x]."</span></a>";
            echo $output;
        }
    }
    ?>
</div>
