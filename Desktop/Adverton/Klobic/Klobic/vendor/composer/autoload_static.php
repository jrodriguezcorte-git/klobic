<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite346999a734cf31b6067dd5f55eb0c56
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Process\\' => 26,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'K' => 
        array (
            'Knp\\Snappy' => 
            array (
                0 => __DIR__ . '/..' . '/knplabs/knp-snappy/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite346999a734cf31b6067dd5f55eb0c56::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite346999a734cf31b6067dd5f55eb0c56::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite346999a734cf31b6067dd5f55eb0c56::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
