<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite1d9d243e1454fdcecadda3c4396dedd
{
    public static $files = array (
        '5f6ea78188a74ae6f96fa6029143ab5a' => __DIR__ . '/..' . '/servo/fluidxml/source/FluidXml/fluid.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FluidXml\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FluidXml\\' => 
        array (
            0 => __DIR__ . '/..' . '/servo/fluidxml/source/FluidXml',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite1d9d243e1454fdcecadda3c4396dedd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite1d9d243e1454fdcecadda3c4396dedd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}