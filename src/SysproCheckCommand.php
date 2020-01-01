<?php
namespace BWT;

use BWT\Syspro;
use Hash\Hash;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class SysproCheckCommand extends Command
{
    protected function configure(): void
    {
        $this->setName("Syspro:CheckTrips")
            ->setDescription("Check if a set of trips have posted successfully to Syspro from MAX")
            ->addArgument('BU', InputArgument::OPTIONAL, 'What Business Unit do these trips belong to?')
            ->addArgument(
                'Field',
                InputArgument::REQUIRED,
                'What field do the trips correspond to? Valid options are: ID, tripNumber'
            )
            ->addArgument('Trips', InputArgument::IS_ARRAY, 'What trips do you want to check?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $hash = new Hash();
        $input = $input->getArgument('Password');
        
        $result = $hash->hash($input);
        
        $output->writeln("Your password hashed: {$result}");
    }
}
