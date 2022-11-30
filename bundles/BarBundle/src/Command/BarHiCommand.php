<?php

namespace bundles\BarBundle\src\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'bar:hi',
    description: 'BarBundle should introduce the bar:hi console command and register it as a member of foo:hello.' .
    ' If this command were not registered as a member of a chain, it would produce the following output:',
)]
class BarHiCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('Hi from Bar!');

        return Command::SUCCESS;
    }
}
