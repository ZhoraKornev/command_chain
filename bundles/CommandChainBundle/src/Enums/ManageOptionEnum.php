<?php

namespace bundles\CommandChainBundle\src\Enums;

//todo refactor to enum after upgrade to php 8.1
enum ManageOptionEnum
{
    public const ADD_ACTION = 'add';
    public const REMOVE_ACTION = 'remove';
    public const LIST_ACTION = 'list';
    public const COMMAND_CHAIN_PARAM_NAME = 'command_chain';
}