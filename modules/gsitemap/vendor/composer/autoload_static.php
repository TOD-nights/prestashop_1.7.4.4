<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite7772f77bba645b0ef9fb0c2c6dce687
{
    public static $classMap = array (
        'Gsitemap' => __DIR__ . '/../..' . '/gsitemap.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInite7772f77bba645b0ef9fb0c2c6dce687::$classMap;

        }, null, ClassLoader::class);
    }
}