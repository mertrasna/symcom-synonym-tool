<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf73c47c96851f5210d4d2bc9b958aa85
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpOffice\\PhpWord\\' => 18,
        ),
        'L' => 
        array (
            'Laminas\\Escaper\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpOffice\\PhpWord\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpword/src/PhpWord',
        ),
        'Laminas\\Escaper\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-escaper/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'R' => 
        array (
            'Raven_' => 
            array (
                0 => __DIR__ . '/..' . '/sentry/sentry/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf73c47c96851f5210d4d2bc9b958aa85::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf73c47c96851f5210d4d2bc9b958aa85::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitf73c47c96851f5210d4d2bc9b958aa85::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitf73c47c96851f5210d4d2bc9b958aa85::$classMap;

        }, null, ClassLoader::class);
    }
}
