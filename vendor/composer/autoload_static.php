<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitce00d19d05f6cffc0285c2299bf27a03
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Scaffolding\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Scaffolding\\' => 
        array (
            0 => __DIR__ . '/..' . '/gcsystem/scaffolding/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitce00d19d05f6cffc0285c2299bf27a03::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitce00d19d05f6cffc0285c2299bf27a03::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
