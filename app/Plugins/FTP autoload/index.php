<?php

use Nidavel\FtpAutoLoad\Classes\FTPA;

require_once 'vendor/autoload.php';
require_once plugin_path('FTP autoload/routes/index.php');

registerSettingsForm('FTP autoload', 'ftpa', plugin_path('FTP autoload/pages/settings.php'));

function uploadRecentMedia(string $media = 'images')
{
    $dir    = public_path("my_exports/uploads/$media");
    $remoteDir = settings('r', 'ftpa.pub_dir');
    $files  = getFilepaths($dir);
    $ftpa   = FTPA::getInstance();
    if (is_null($ftpa)) {
        return false;
    }
    foreach ($files as $file) {
        if (time() - filemtime($file) < 86400) {
            $ftpa::put("$remoteDir/uploads/$media/".basename($file), $file);
        }
    }
}

function uploadPostToPublic($post)
{
    $subdir = '';
    if (empty(settings('r', 'ftpa.upload_on_post_publish'))) {
        return;
    }
    if ($post->category == null && $post->post_type == 'post') {
        $subdir = 'posts';
    }
    else if (!is_null($post->category)) {
        $subdir = $post->category;
    } else {
        $subdir = 'pages';
    }
    $localFile      = public_path("my_exports/$subdir/$post->link.html");
    $remoteFile     = settings('r', 'ftpa.pub_dir')."/$subdir/$post->link.html";
    $ftpa           = FTPA::getInstance();
    if (is_null($ftpa)) {
        return false;
    }
    $ftpa::put($remoteFile, $localFile);
    uploadRecentMedia('images');
    uploadRecentMedia('audios');
    uploadRecentMedia('videos');
    $ftpa::close();
}

function deletePostFromPublic($post)
{
    $subdir = '';
    if (empty(settings('r', 'ftpa.upload_on_post_publish'))) {
        return;
    }
    if ($post->category == null && $post->post_type == 'post') {
        $subdir = 'posts';
    }
    else if (!is_null($post->category)) {
        $subdir = $post->category;
    } else {
        $subdir = 'pages';
    }
    $remoteDir  = settings('r', 'ftpa.pub_dir')."/$subdir";
    $remoteFile = "$remoteDir/$post->link.html";
    $ftpa       = FTPA::getInstance();
    if (is_null($ftpa)) {
        return false;
    }
    $ftpa::delete($remoteFile);
    $dirItems = $ftpa::nlist($remoteDir);
    if (count($dirItems) == 0) {
        $ftpa::rmdir($remoteDir);
    }
    $ftpa::close();
}

runOnPostPublish('uploadPostToPublic');
runOnPostDelete('deletePostFromPublic');
