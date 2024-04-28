<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit73b1ca57af6ca7f21171015de32d2a6b
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Nidavel\\Sitemap\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Nidavel\\Sitemap\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit73b1ca57af6ca7f21171015de32d2a6b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit73b1ca57af6ca7f21171015de32d2a6b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit73b1ca57af6ca7f21171015de32d2a6b::$classMap;

        }, null, ClassLoader::class);
    }
}
