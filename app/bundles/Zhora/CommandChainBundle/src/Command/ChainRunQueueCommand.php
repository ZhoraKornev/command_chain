<?php

namespace Zhora\CommandChainBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\ArrayInput;

#[AsCommand(
    name: 'chain:run-queue',
    description: 'Add a short description for your command',
)]
class ChainRunQueueCommand extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->getAllRegisteredCommand() as $command) {
            $commandName = $command['name'];
            $io->note(sprintf('Work with: %s', $commandName));
            $command = $this->getApplication()->find($commandName);
            try {
                $command->run($input, $output);
            } catch (ExceptionInterface $e) {
                dd($e->getMessage(),$e->getCode());
            }
            continue;
            $arguments = [
                'name' => 'Fabien',
                '--yell' => true,
            ];
            $greetInput = new ArrayInput($arguments);
            $returnCode = $command->run($greetInput, $output);


        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }

    protected function getAllRegisteredCommand(): array
    {
//        $commandsPool[]['name'] = 'foo:required-params';
        $commandsPool[]['name'] = 'foo:hello';
        $commandsPool[]['name'] = 'bar:hi';
        return $commandsPool;
    }
}
