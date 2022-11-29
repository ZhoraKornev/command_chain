<?php

declare(strict_types=1);

namespace Zhora\CommandChainBundle\Tests\Unit\EventListener;

use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\Output\OutputInterface;
use Zhora\CommandChainBundle\EventListener\ConsoleCommandListener;
use Zhora\CommandChainBundle\Providers\CommandProvider;
use Zhora\CommandChainBundle\Repository\CommandKeeper;

class ConsoleListenerTest extends TestCase
{
    protected ConsoleCommandListener $serviceToTest;

    protected MockObject|CommandProvider $commandProviderMock;
    protected MockObject|CommandKeeper $commandsMock;
    protected MockObject|LoggerInterface $logger;

    /**
     * Set up
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->commandProviderMock = $this->getMockBuilder(CommandProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->commandsMock = $this->getMockBuilder(CommandKeeper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceToTest = new ConsoleCommandListener(
            $this->commandProviderMock,
            $this->loggerMock,
            $this->commandsMock
        );
    }

    public function testOnConsoleCommandNormal(): void
    {
        //TODO refactor to data provider
        $commandName = 'testCommandName';
        /** @var ConsoleEvent|MockObject $consoleEventMock */
        $consoleEventMock = $this->getMockBuilder(ConsoleEvent::class)
            ->disableOriginalConstructor()
            ->getMock();
        $outputInterfaceMock = $this->createMock(OutputInterface::class);
        $commandMock = $this->getMockBuilder(Command::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getName'])
            ->getMock()
        ;
        $consoleEventMock->expects($this->once())
            ->method('getOutput')
            ->willReturn($outputInterfaceMock);

        $consoleEventMock->expects($this->once())
            ->method('getCommand')
            ->willReturn($commandMock);

        $commandMock->expects($this->once())
            ->method('getName')
            ->willReturn($commandName);

        $this->commandProviderMock->expects(($this->once()))
            ->method('isSubChainCommand')
            ->with($commandName)
            ->willReturn(true);

        $this->commandProviderMock->expects(($this->once()))
            ->method('isMasterCommand')
            ->willReturn(true);

        $this->serviceToTest->onConsoleCommand($consoleEventMock);
    }
}
