<?php

namespace Zhora\CommandChainBundle\Providers;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Zhora\CommandChainBundle\Repository\CommandKeeper;

class CommandProvider
{
    private CommandKeeper $commands;

    public function __construct(CommandKeeper $commandKeeper)
    {
        $this->commands = $commandKeeper;
    }

    public function isMasterCommand(string $commandName): bool
    {
        $commands = $this->commands->getRegisteredCommands();
        return empty($commands[$commandName]) === false;
    }

    public function isChainCommand(string $commandName): bool
    {
        $commands = $this->commands->getRegisteredCommands();
        if ($this->isMasterCommand($commandName)) {
            return true;
        }
        foreach ($commands as $subCommand) {
            if (in_array($commandName, $subCommand)) {
                return true;
            }
        }
        return false;
    }

    public function isSubChainCommand(string $commandName): bool
    {
        $commands = $this->commands->getRegisteredCommands();
        if ($this->isMasterCommand($commandName)) {
            return false;
        }
        foreach ($commands as $subCommand) {
            if (in_array($commandName, $subCommand)) {
                return true;
            }
        }
        return false;
    }
}
