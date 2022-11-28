<?php

namespace Zhora\CommandChainBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\ConsoleEvents;

class ConsoleCommandListener
{
    //see https://symfony.com/doc/current/components/console/events.html
    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        // get the output instance
        $output = $event->getOutput();

        // get the command to be executed
        $command = $event->getCommand();

        // write something about the command
        $output->writeln(sprintf('Before running command <info>%s</info>', $command->getName()));


        $command = $event->getCommand();
//
//        if (!$this->commandProvider->isCommandFromChain($command)) {
//            return;
//        }
//
//        if ($command instanceof CommandChainingInterface
//            && $command->isMasterCommand() === false
//        ) {
//            $event->stopPropagation();
//
//            throw new NotMasterCommandException(get_class($command));
//        }
//
//        if ($command instanceof Command) {
//            $this->logRegisteredChainCommands($command);
//        }

    }

}