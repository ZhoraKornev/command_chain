<?php

namespace Zhora\CommandChainBundle\Exception;

class SubCommandRunException extends \Exception
{
    protected $message = 'Error happened when command try to find and run in application see log';
}
