<?php

require_once base_path('/app/Blasta/Classes/Tag.php');

function updateTags(?string $keywordString = null)
{
    if ($keywordString === null) {
        return;
    }
    
    $tags = Tag::getInstance();
    $keywords = $tags->parse($keywordString);
    $tags->add(...$keywords);
}