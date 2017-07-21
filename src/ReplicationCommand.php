<?php
namespace Noondaysun\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Noondaysun\Cli\Replications;

/**
 * Check mySQL replication from the cli
 *
 * @author Feighen Oosterbroek <foosterbroek@bwtrans.co.za>
 *
 */
class ReplicationCommand extends Command
{

    protected function configure()
    {
        $this->setName("Replication:checkReplication")->setDescription("Check replication in a mysql master::slave setup");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repl = new Replication();
        $data = $repl->checkReplication();
        
        print_r($data);
    }
}
