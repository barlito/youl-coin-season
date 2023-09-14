<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DefaultContext implements Context
{
    /**
     * Ensure to fully reset the test database fixtures features, allowing easy knowledge of the current
     * database state at the beginning of each features
     *
     * @Given I reload the fixtures
     *
     * @BeforeFeature
     */
    public static function prepareFixtures(): void
    {
        //        system('bin/console hautelook:fixtures:load -n --env="test"');
    }

    /**
     * Clean cache before feature
     *
     * @BeforeFeature @needCleanCachePool
     */
    public static function clearCachePool(): void
    {
        system('bin/console cache:pool:clear cache.app --env="test"');
    }
}
