<?php

require_once base_path('/app/Blasta/Classes/PostHead.php');

/**
 * The meta tags in the post head
 */
function postHead($post = null)
{
    $postHeadString = '';
    $postHeadMeta = PostHead::get();

    if ($post !== null) {
        $postHeads[] = '<meta name="author" content="'.$post->author.'" />';
        $postHeads[] = '<meta name="description" content="'.$post->description.'" />';
        $postHeads[] = '<meta name="keywords" content="'.$post->keywords.'" />';
        $postHeads[] = '<title>'.$post->title.'</title>';

        foreach ($postHeads as $postHead) {
            $postHeadString .= "$postHead\n";
        }
    }

    $postHeadString .= $postHeadMeta;
    
    return $postHeadString;
}

/**
 * Appends to post head
 */
function appendToPostHead(string $meta)
{
    PostHead::append($meta);
}
