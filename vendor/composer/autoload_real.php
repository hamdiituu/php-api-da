<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit1ec3fb0a3291108073aa6d257bbef07c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit1ec3fb0a3291108073aa6d257bbef07c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit1ec3fb0a3291108073aa6d257bbef07c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit1ec3fb0a3291108073aa6d257bbef07c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
