<?php

require_once base_path('/app/Blasta/Classes/PostHead.php');

/**
 * The meta tags in the post head
 */
function postHead($post = null)
{
    $protocol = settings('r', 'general.protocol');
    $domain = settings('r', 'general.domain');

    $postHeadString = '';
    $postHeadMeta = PostHead::get();

    if ($post !== null) {
        $postHeads[] = '<meta name="author" content="'.$post->author.'" />';
        $postHeads[] = '<meta name="description" content="'.$post->description.'" />';
        $postHeads[] = '<meta name="keywords" content="'.$post->keywords.'" />';
        $postHeads[] = '<meta name="theme-color" content="'.settings('r', 'general.theme_color').'" />';
        $postHeads[] = '<title>'.$post->title.'</title>';

        $postHeads[] = '<meta property="og:title" content="'.$post->title.'" />';
        $postHeads[] = '<meta property="og:url" content="'.$protocol.'://'.$domain.'/'.$post->post_type.'s/'.$post->link.'.html" />';
        $postHeads[] = '<meta property="og:image" content="'.$protocol.'://'.$domain.'/uploads/'.$post->featured_image.'" />';
        $postHeads[] = '<meta property="og:image:width" content="1200" />';
        $postHeads[] = '<meta property="og:image:height" content="630" />';
        $postHeads[] = '<meta property="og:type" content="article" />';
        $postHeads[] = '<meta property="og:description" content="'.$post->description.'" />';

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
