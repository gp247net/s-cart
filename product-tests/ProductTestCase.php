<?php

namespace ProductTests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\ConfigurationUrlParser;
use Illuminate\Support\Env;

/**
 * Base class of the S-Cart product tests: checks run against an S-Cart that was just
 * installed (or upgraded) with `php artisan gp247:install`.
 *
 * Refuses a database that is not marked as a test database (name ending with _test or
 * _testing, or named by GP247_TEST_DATABASE) before any test runs.
 *
 * WHY its own check and not GP247\Core\Testing\GuardsTestDatabase: the product tests
 * run on the gp247/core version S-Cart requires, and the released versions up to that
 * floor do not ship GP247\Core\Testing yet. Switch to the core trait once the S-Cart
 * floor includes it.
 *
 * @aidlc-unit installer-deploy
 * @aidlc-story US-DEP-product-install-ci
 */
abstract class ProductTestCase extends BaseTestCase
{
    /**
     * Refuse a non-test database, then boot the testing traits as usual.
     *
     * @return array
     */
    protected function setUpTraits()
    {
        $confirmed = (string) Env::get('GP247_TEST_DATABASE', '');
        $default = (string) config('database.default');
        foreach (array_unique(array_filter([$default, (string) config('gp247-config.env.GP247_DB_CONNECTION', '')])) as $connection) {
            $parsed = (new ConfigurationUrlParser())->parseConfiguration((array) config("database.connections.$connection", []));
            $database = (string) ($parsed['database'] ?? '');
            $allowed = preg_match('/_(test|testing)(_test_\d+)?$/', $database) === 1
                || ($confirmed !== '' && $database === $confirmed);
            if (!$allowed) {
                $this->fail(sprintf(
                    'Refusing to run the product tests on database "%s" (connection "%s"): it is not marked as a test database. '
                    . 'Use a database whose name ends with _test or _testing, or set GP247_TEST_DATABASE=<database name>.',
                    $database,
                    $connection
                ));
            }
        }

        return parent::setUpTraits();
    }
}
