<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4a8a9d2eab91c0cc9838fb315fd53bf4
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Nidavel\\Feed\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Nidavel\\Feed\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit4a8a9d2eab91c0cc9838fb315fd53bf4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4a8a9d2eab91c0cc9838fb315fd53bf4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4a8a9d2eab91c0cc9838fb315fd53bf4::$classMap;

        }, null, ClassLoader::class);
    }
}
