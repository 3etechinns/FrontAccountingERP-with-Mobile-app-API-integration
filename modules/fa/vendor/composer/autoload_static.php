<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite78204370ba3f567d9937406f9be7acd
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FAAPI\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FAAPI\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite78204370ba3f567d9937406f9be7acd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite78204370ba3f567d9937406f9be7acd::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite78204370ba3f567d9937406f9be7acd::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}