<?php
declare(strict_types=1);

/**
 * File:GetModelDetailsCommandTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\Cli\Test\Unit\Command;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTOInterface;
use MSlwk\Otomoto\App\Stats\Data\StatsDTOInterface;
use MSlwk\Otomoto\App\Stats\Filter\FilterFactory;
use MSlwk\Otomoto\App\Stats\Filter\FilterInterface;
use MSlwk\Otomoto\Cli\Command\GetModelDetailsCommand;
use MSlwk\Otomoto\Middleware\App\Stats\Stats;
use MSlwk\Otomoto\Middleware\App\Stats\StatsFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GetModelDetailsCommandTest
 * @package MSlwk\Otomoto\Cli\Test\Unit\Command
 */
class GetModelDetailsCommandTest extends TestCase
{
    /**
     * @var MockObject|StatsFactory
     */
    private $statsFactory;

    /**
     * @var MockObject|FilterFactory
     */
    private $filterFactory;

    /**
     * @var MockObject|GetModelDetailsCommand
     */
    private $command;

    /**
     * @var MockObject|InputInterface
     */
    private $input;

    /**
     * @var MockObject|OutputInterface
     */
    private $output;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->statsFactory = $this->getMockBuilder(StatsFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->filterFactory = $this->getMockBuilder(FilterFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->input = $this->getMockBuilder(InputInterface::class)
            ->getMock();
        $this->output = $this->getMockBuilder(OutputInterface::class)
            ->getMock();

        $this->command = new GetModelDetailsCommand(
            $this->statsFactory,
            $this->filterFactory
        );
    }

    /**
     * @test
     */
    public function testCommandHasCorrectName()
    {
        $this->assertEquals(GetModelDetailsCommand::COMMAND_NAME, $this->command->getName());
    }

    /**
     * @test
     */
    public function testCommandHasCorrectDescription()
    {
        $this->assertEquals(GetModelDetailsCommand::COMMAND_DESC, $this->command->getDescription());
    }

    /**
     * @test
     */
    public function testCommandHasCorrectParams()
    {
        $expectedArgumentCount = 2;
        $expectedOptionCount = 2;
        $expectedArgumentType = InputArgument::class;
        $expectedOptionType = InputOption::class;

        $commandDefinition = $this->command->getDefinition();

        $this->assertEquals($expectedArgumentCount, $commandDefinition->getArgumentCount());
        $this->assertInstanceOf(
            $expectedArgumentType,
            $commandDefinition->getArgument(GetModelDetailsCommand::MANUFACTURER_ARG_NAME)
        );
        $this->assertInstanceOf(
            $expectedArgumentType,
            $commandDefinition->getArgument(GetModelDetailsCommand::MODEL_ARG_NAME)
        );
        $this->assertEquals(
            GetModelDetailsCommand::MANUFACTURER_ARG_DESC,
            $commandDefinition->getArgument(GetModelDetailsCommand::MANUFACTURER_ARG_NAME)->getDescription()
        );
        $this->assertEquals(
            GetModelDetailsCommand::MODEL_ARG_DESC,
            $commandDefinition->getArgument(GetModelDetailsCommand::MODEL_ARG_NAME)->getDescription()
        );

        $this->assertEquals($expectedOptionCount, count($commandDefinition->getOptions()));
        $this->assertInstanceOf(
            $expectedOptionType,
            $commandDefinition->getOption(GetModelDetailsCommand::FROM_YEAR_OPTION_NAME)
        );
        $this->assertInstanceOf(
            $expectedOptionType,
            $commandDefinition->getOption(GetModelDetailsCommand::TO_YEAR_OPTION_NAME)
        );
        $this->assertEquals(
            GetModelDetailsCommand::FROM_YEAR_OPTION_DESC,
            $commandDefinition->getOption(GetModelDetailsCommand::FROM_YEAR_OPTION_NAME)->getDescription()
        );
        $this->assertEquals(
            GetModelDetailsCommand::FROM_YEAR_OPTION_SHORTCUT,
            $commandDefinition->getOption(GetModelDetailsCommand::FROM_YEAR_OPTION_NAME)->getShortcut()
        );
        $this->assertEquals(
            GetModelDetailsCommand::TO_YEAR_OPTION_DESC,
            $commandDefinition->getOption(GetModelDetailsCommand::TO_YEAR_OPTION_NAME)->getDescription()
        );
        $this->assertEquals(
            GetModelDetailsCommand::TO_YEAR_OPTION_SHORTCUT,
            $commandDefinition->getOption(GetModelDetailsCommand::TO_YEAR_OPTION_NAME)->getShortcut()
        );
    }

    /**
     * @test
     */
    public function testExecuteWithFilters()
    {
        $this->input->expects($this->exactly(2))
            ->method('getArgument')
            ->willReturnOnConsecutiveCalls('BMW', 'M3');
        $this->input->expects($this->once())
            ->method('getOptions')
            ->will(
                $this->returnValue(
                    [
                        'from' => 2015
                    ]
                )
            );

        $filter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();

        $this->filterFactory->expects($this->once())
            ->method('create')
            ->with('from', 2015)
            ->will($this->returnValue($filter));

        $statsMiddleware = $this->getMockBuilder(Stats::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->statsFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($statsMiddleware));

        $stats = $this->getMockBuilder(StatsDTOInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $statsMiddleware->expects($this->once())
            ->method('getStats')
            ->will($this->returnValue($stats));

        $stats->expects($this->once())
            ->method('getAverageMileage')
            ->will($this->returnValue(300.21));
        $stats->expects($this->once())
            ->method('getAveragePrice')
            ->will($this->returnValue(300.21));
        $stats->expects($this->once())
            ->method('getAverageYear')
            ->will($this->returnValue(300.21));

        $this->output->expects($this->exactly(6))
            ->method('writeln');

        $reflection = new \ReflectionClass(get_class($this->command));
        $method = $reflection->getMethod('execute');
        $method->setAccessible(true);

        $method->invokeArgs($this->command, [$this->input, $this->output]);
    }
}
