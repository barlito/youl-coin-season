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
    private CommandTester $commandTester;

    /**
     * @When I run the command :command
     */
    public function iRunTheCommand($command)
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $command = $application->find($command);

        $this->commandTester = new CommandTester($command);
        $this->commandTester->execute([]);

        $this->output = $this->commandTester->getDisplay();
    }

    /**
     * @Given command output should contain :message
     */
    public function commandOutShouldContains($message)
    {
        $this->assertStringContainsString($message, $this->output);
    }

    /**
     * @Then the command should be successful
     */
    public function theCommandShouldBeSuccessful()
    {
        $this->commandTester->assertCommandIsSuccessful();
    }

    /**
     * @Then /^the command should be a failure$/
     */
    public function theCommandShouldBeAFailure()
    {
        $this->assertEquals(1, $this->commandTester->getStatusCode());
    }
}
