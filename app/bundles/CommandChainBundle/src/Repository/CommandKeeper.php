<?php

namespace Zhora\CommandChainBundle\Repository;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Zhora\CommandChainBundle\Enums\ManageOptionEnum;

class CommandKeeper
{
    private ParameterBagInterface $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getRegisteredCommands(): array
    {
        $result = [];
        //TODO put this into cache for best performance
        if ($this->params->get(ManageOptionEnum::COMMAND_CHAIN_PARAM_NAME)) {
            $result = $this->params->get(ManageOptionEnum::COMMAND_CHAIN_PARAM_NAME);
        }
        return $result;
    }

    public function getSubChainCommands(string $masterChainName): array
    {
        $result = [];
        if (empty($this->getRegisteredCommands()[$masterChainName])) {
            return $result;
        }
        return $this->getRegisteredCommands()[$masterChainName];
    }
}
