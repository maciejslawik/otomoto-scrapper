<?php
/**
 * File: ListManufacturersCommandTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Cli\Test\Unit\Command;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use MSlwk\Otomoto\Cli\Command\ListManufacturersCommand;
use MSlwk\Otomoto\Middleware\App\Manufacturer\Manufacturer;
use MSlwk\Otomoto\Middleware\App\Manufacturer\ManufacturerFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListManufacturersCommandTest
 * @package MSlwk\Otomoto\Cli\Test\Command
 */
class ListManufacturersCommandTest extends TestCase
{
    /**
     * @var MockObject|ManufacturerFactory
     */
    private $manufacturerMiddlewareFactory;

    /**
     * @var MockObject|ListManufacturersCommand
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
     * @var MockObject|Manufacturer
     */
    private $manufacturerMiddleware;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->manufacturerMiddlewareFactory = $this->getMockBuilder(ManufacturerFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->input = $this->getMockBuilder(InputInterface::class)
            ->getMock();
        $this->output = $this->getMockBuilder(OutputInterface::class)
            ->getMock();
        $this->manufacturerMiddleware = $this->getMockBuilder(Manufacturer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->command = new ListManufacturersCommand($this->manufacturerMiddlewareFactory);
    }

    /**
     * @return array
     */
    public function manufacturersDataProvider(): array
    {
        return [
            [
                new ManufacturerDTOArray(
                    new ManufacturerDTO('Audi'),
                    new ManufacturerDTO('Volkswagen'),
                    new ManufacturerDTO('Alpine'),
                    new ManufacturerDTO('Opel'),
                    new ManufacturerDTO('BMW')
                ),
                4
            ],
            [
                new ManufacturerDTOArray(
                    new ManufacturerDTO('Audi'),
                    new ManufacturerDTO('Volkswagen'),
                    new ManufacturerDTO('Renault'),
                    new ManufacturerDTO('Opel'),
                    new ManufacturerDTO('BMW')
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
        $this->assertEquals(ListManufacturersCommand::COMMAND_NAME, $this->command->getName());
    }

    /**
     * @test
     */
    public function testCommandHasCorrectDescription()
    {
        $this->assertEquals(ListManufacturersCommand::COMMAND_DESC, $this->command->getDescription());
    }

    /**
     * @test
     * @dataProvider manufacturersDataProvider
     * @param ManufacturerDTOArray $manufacturers
     * @param int $expectedCount
     */
    public function testExecuteCallsWritelnCorrectly(ManufacturerDTOArray $manufacturers, int $expectedCount)
    {

        $this->manufacturerMiddleware->expects($this->once())
            ->method('getManufacturers')
            ->will($this->returnValue($manufacturers));

        $this->manufacturerMiddlewareFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->manufacturerMiddleware));

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
    public function testGroupManufacturersByFirstLetter()
    {
        $manufacturers = new ManufacturerDTOArray(
            new ManufacturerDTO('Audi'),
            new ManufacturerDTO('Volkswagen'),
            new ManufacturerDTO('Renault'),
            new ManufacturerDTO('Bugatti'),
            new ManufacturerDTO('BMW')
        );

        $reflection = new \ReflectionClass(get_class($this->command));
        $method = $reflection->getMethod('groupManufacturersByFirstLetter');
        $method->setAccessible(true);

        $result = $method->invokeArgs($this->command, [$manufacturers]);

        $this->assertNotEmpty($result);
        $this->assertEquals(4, count($result));
        $this->assertEquals('A: Audi', $result['A']);
        $this->assertEquals('B: Bugatti, BMW', $result['B']);
        $this->assertEquals('R: Renault', $result['R']);
        $this->assertEquals('V: Volkswagen', $result['V']);
    }
}
