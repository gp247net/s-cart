<?php

/**
 * Bootstrap of the S-Cart product tests: load the application's autoloader and
 * register the ProductTests namespace (kept out of composer.json so the folder can be
 * dropped from the install package without leaving a dangling autoload entry).
 *
 * @aidlc-unit installer-deploy
 * @aidlc-story US-DEP-product-install-ci
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

foreach (\Composer\Autoload\ClassLoader::getRegisteredLoaders() as $loader) {
    if (!isset($loader->getPrefixesPsr4()['ProductTests\\'])) {
        $loader->addPsr4('ProductTests\\', __DIR__ . '/');
    }
    break;
}
