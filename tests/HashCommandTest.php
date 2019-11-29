<?php

use Hash\HashCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * From: https://www.sitepoint.com/re-introducing-symfony-console-cli-php-uninitiated/
 *
 * @author Cláudio Ribeiro
 *
 */
class HashCommandTest extends TestCase
{

    public function testHashIsCorrect(): void
    {
        $application = new Application();
        $application->add(new HashCommand());
        
        $command = $application->find('Hash:Hash');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'Password' => 'Sitepoint'
        ));
        
        $this->assertRegExp('/Your password hashed:/', $commandTester->getDisplay());
    }
}
