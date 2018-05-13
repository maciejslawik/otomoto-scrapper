<?php
/**
 * File: ListModelsCommandTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Cli\Test\Unit\Command;

use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MSlwk\Otomoto\Middleware\App\Model\ModelFactory;
use MSlwk\Otomoto\Middleware\App\Model\Model;
use MSlwk\Otomoto\Cli\Command\ListModelsCommand;

/**
 * Class ListModelsCommandTest
 * @package MSlwk\Otomoto\Cli\Test\Unit\Command
 */
class ListModelsCommandTest extends TestCase
{
    /**
     * @var MockObject|ModelFactory
     */
    private $modelMiddlewareFactory;

    /**
     * @var MockObject|ListModelsCommand
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
     * @var MockObject|Model
     */
    private $modelMiddleware;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->modelMiddlewareFactory = $this->getMockBuilder(ModelFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->input = $this->getMockBuilder(InputInterface::class)
            ->getMock();
        $this->output = $this->getMockBuilder(OutputInterface::class)
            ->getMock();
        $this->modelMiddleware = $this->getMockBuilder(Model::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->command = new ListModelsCommand($this->modelMiddlewareFactory);
    }

    /**
     * @return array
     */
    public function modelsDataProvider(): array
    {
        return [
            [
                new ModelDTOArray(
                    new ModelDTO('Giulia'),
                    new ModelDTO('Giulietta'),
                    new ModelDTO('Stelvio'),
                    new ModelDTO('GTV'),
                    new ModelDTO('Brera')
                ),
                3
            ],
            [
                new ModelDTOArray(
                    new ModelDTO('Auris'),
                    new ModelDTO('Supra'),
                    new ModelDTO('RAV4'),
                    new ModelDTO('Hilux'),
                    new ModelDTO('GT86')
                ),
                5
            ]
        ];
    }

    /**
     * @test
     */
    public function testCommandHasCorrectName()
    {
        $this->assertEquals(ListModelsCommand::COMMAND_NAME, $this->command->getName());
    }

    /**
     * @test
     */
    public function testCommandHasCorrectDescription()
    {
        $this->assertEquals(ListModelsCommand::COMMAND_DESC, $this->command->getDescription());
    }

    /**
     * @test
     */
    public function testCommandHasCorrectArguments()
    {
        $commandDefinition = $this->command->getDefinition();

        $expectedCount = 1;
        $expectedType = InputArgument::class;
        $expectedDescription = ListModelsCommand::MANUFACTURER_ARG_DESC;
        $this->assertEquals($expectedCount, $commandDefinition->getArgumentCount());
        $this->assertInstanceOf(
            $expectedType,
            $commandDefinition->getArgument(ListModelsCommand::MANUFACTURER_ARG_NAME)
        );
        $this->assertEquals(
            $expectedDescription,
            $commandDefinition->getArgument(ListModelsCommand::MANUFACTURER_ARG_NAME)->getDescription()
        );
    }

    /**
     * @test
     * @dataProvider modelsDataProvider
     * @param ModelDTOArray $models
     * @param int $expectedCount
     */
    public function testExecuteCallsWritelnCorrectly(ModelDTOArray $models, int $expectedCount)
    {
        $this->input->expects($this->once())
            ->method('getArgument')
            ->will($this->returnValue('Audi'));
        $this->modelMiddleware->expects($this->once())
            ->method('getModels')
            ->will($this->returnValue($models));

        $this->modelMiddlewareFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->modelMiddleware));

        $this->output->expects($this->exactly($expectedCount))
            ->method('writeln');

        $reflection = new \ReflectionClass(get_class($this->command));
        $method = $reflection->getMethod('execute');
        $method->setAccessible(true);

        $method->invokeArgs($this->command, [$this->input, $this->output]);
    }

    /**
     * @test
     */
    public function testGroupModelsByFirstLetter()
    {
        $models = new ModelDTOArray(
            new ModelDTO('Gallardo'),
            new ModelDTO('Reventon'),
            new ModelDTO('Murcielargo'),
            new ModelDTO('Miura'),
            new ModelDTO('Huracan')
        );

        $reflection = new \ReflectionClass(get_class($this->command));
        $method = $reflection->getMethod('groupModelsByFirstLetter');
        $method->setAccessible(true);

        $result = $method->invokeArgs($this->command, [$models]);

        $this->assertNotEmpty($result);
        $this->assertEquals(4, count($result));
        $this->assertEquals('G: Gallardo', $result['G']);
        $this->assertEquals('H: Huracan', $result['H']);
        $this->assertEquals('M: Murcielargo, Miura', $result['M']);
        $this->assertEquals('R: Reventon', $result['R']);
    }
}
