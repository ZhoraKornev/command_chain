<?php

namespace Zhora\CommandChainBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Zhora\CommandChainBundle\Exception\NotMasterCommandException;
use Zhora\CommandChainBundle\Providers\CommandProvider;
use Symfony\Component\Console\Command\Command;
use Zhora\CommandChainBundle\Repository\CommandKeeper;

class ConsoleCommandListener
{
    private CommandProvider $commandProvider;
    private LoggerInterface $logger;
    private CommandKeeper $commands;

    public function __construct(CommandProvider $provider, LoggerInterface $logger, CommandKeeper $commandKeeper)
    {
        $this->commandProvider = $provider;
        $this->logger = $logger;
        $this->commands = $commandKeeper;
    }

    /**
     * @throws NotMasterCommandException
     */
    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        // get the output instance
        $output = $event->getOutput();

        // get the command to be executed
        $command = $event->getCommand();
        $commandName = $command->getName();
        // write something about the command
        $output->writeln(sprintf('Check global eventListener <info>%s</info>', $commandName));

        if ($this->commandProvider->isSubChainCommand($commandName)) {
            $event->stopPropagation();
            throw new NotMasterCommandException();
        }

        if ($this->commandProvider->isMasterCommand($commandName)) {
            $subChainCommandNames = $this->commands->getSubChainCommands($commandName);
            foreach ($subChainCommandNames as $subChainCommandName) {
                $subCommand = $command->getApplication()->find($subChainCommandName);
                try {
                    $subCommand->run($event->getInput(), $event->getOutput());
                } catch (ExceptionInterface $exception) {
                }
            }
        }
        if ($this->commandProvider->isChainCommand($commandName)) {
            $this->logRegisteredChainCommands($command);
        }
    }

    protected function logRegisteredChainCommands(Command $command): void
    {
        $this->logger->notice(
            sprintf(
                '%s is a master command of a command chain that has registered member commands',
                $command->getName()
            )
        );
    }
}
