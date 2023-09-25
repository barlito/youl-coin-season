<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class CommandContext extends KernelTestCase implements Context
{
    private string $output = '';

    /**
     * @When I run the command :command
     */
    public function iRunTheCommand($command)
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $command = $application->find($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();

        $this->output = $commandTester->getDisplay();
    }

    /**
     * @Given command out should contain :message
     */
    public function commandOutShouldContains($message)
    {
        $this->assertStringContainsString($message, $this->output);
    }
}
