<?php

namespace bundles\FooBundle\src\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'foo:hello',
    description: 'FooBundle should introduce the foo:hello console command.' .
    ' This command, if there were no other commands registered in its chain, would produce the following output:',
)]
class FooHelloCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('Hello from Foo!');

        return Command::SUCCESS;
    }
}
