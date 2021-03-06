<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0033fd1ca44a5ea6db6e6588fc94b999
{
    public static $files = array (
        '00ac9c10ad5ecdb9ae7c67080d848c58' => __DIR__ . '/..' . '/urbanairship/urbanairship/src/UrbanAirship/Push/Audience.php',
        '9c7096f8022f9a324336b2d58f64a24d' => __DIR__ . '/..' . '/urbanairship/urbanairship/src/UrbanAirship/Push/Notification.php',
        '5fead61b01c74356b6564345865dafb0' => __DIR__ . '/..' . '/urbanairship/urbanairship/src/UrbanAirship/Push/Schedule.php',
    );

    public static $prefixesPsr0 = array (
        'U' => 
        array (
            'UrbanAirship' => 
            array (
                0 => __DIR__ . '/..' . '/urbanairship/urbanairship/src',
            ),
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 
            array (
                0 => __DIR__ . '/..' . '/psr/log',
            ),
        ),
        'M' => 
        array (
            'Monolog' => 
            array (
                0 => __DIR__ . '/..' . '/monolog/monolog/src',
            ),
        ),
        'H' => 
        array (
            'Httpful' => 
            array (
                0 => __DIR__ . '/..' . '/nategood/httpful/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit0033fd1ca44a5ea6db6e6588fc94b999::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
