<?php

namespace Zhora\CommandChainBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Zhora\CommandChainBundle\Enums\ManageOptionEnum;
use Zhora\CommandChainBundle\Repository\CommandKeeper;

#[AsCommand(
    name: 'chain:manage',
    description: 'Add a short description for your command',
)]
class ChainManageCommand extends Command
{

    private const COMMAND_NAME_ARGUMENT = 'command-name';
    private const COMMAND_ACTION = 'manage';

    private CommandKeeper $commands;
    private ParameterBagInterface $params;

    public function __construct(CommandKeeper $commandKeeper,ParameterBagInterface $params)
    {
        parent::__construct();
        $this->commands = $commandKeeper;
        $this->params = $params;
    }

    protected function configure(): void
    {
        $this
            ->addArgument(ChainManageCommand::COMMAND_NAME_ARGUMENT, InputArgument::REQUIRED, 'Command name to manage')
            ->addOption(
                ChainManageCommand::COMMAND_ACTION,
                null,
                InputOption::VALUE_REQUIRED,
                'What need to do(delete or add)',
                ManageOptionEnum::ADD_ACTION
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tmp = $this->params->get('chains');

        $io = new SymfonyStyle($input, $output);
        $commandName = $input->getArgument(ChainManageCommand::COMMAND_NAME_ARGUMENT);
        if ($commandName) {
            try {
                $this->getApplication()->find($commandName);
            } catch (CommandNotFoundException $exception) {
                $io->error($exception->getMessage());
                return Command::FAILURE;
            }
        }

        if ($action = $input->getOption(ChainManageCommand::COMMAND_ACTION)) {
            if (!in_array($action, [
                ManageOptionEnum::ADD_ACTION,
                ManageOptionEnum::REMOVE_ACTION,
                ManageOptionEnum::LIST_ACTION,
            ])) {
                $io->warning('Action provided to class is wrong, exit.');
                $io->info(sprintf(
                        'Available action argument: %s,%s,%s.',
                        ManageOptionEnum::ADD_ACTION,
                        ManageOptionEnum::REMOVE_ACTION,
                        ManageOptionEnum::LIST_ACTION,
                    )
                );
                $io->note(sprintf('You provide %s', $action));
                return Command::FAILURE;
            }
            // ...
        }
        if (!method_exists($this, $action)) {
            $io->warning('Something going wrong - you need to specify this method in class.');
        }
        return $this->$action($io, $commandName);
    }

    protected function add(SymfonyStyle $style,string $commandName): int
    {
        $this->commands->registerCommand($commandName);
        $style->note(sprintf('Command: %s was added to chain list.', $commandName));

        return Command::SUCCESS;
    }

    protected function remove(SymfonyStyle $style,string $commandName): int
    {
        $this->commands->registerCommand($commandName);
        $style->note(sprintf('Command: %s was removed to chain list.', $commandName));
        return Command::SUCCESS;
    }

    protected function list()
    {

    }
}
