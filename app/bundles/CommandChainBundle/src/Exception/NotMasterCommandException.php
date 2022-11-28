<?php

namespace Zhora\CommandChainBundle\Exception;

class NotMasterCommandException extends \Exception
{
    protected $message = 'You try to run sub chain command out of master';
}
