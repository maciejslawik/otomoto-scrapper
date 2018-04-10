<?php
/**
 * File: ListManufacturersCommandTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Cli\Test\Unit\Command;

use MSlwk\Otomoto\Cli\Command\ListManufacturersCommand;
use PHPUnit\Framework\TestCase;

/**
 * Class ListManufacturersCommandTest
 * @package MSlwk\Otomoto\Cli\Test\Command
 */
class ListManufacturersCommandTest extends TestCase
{
    /**
     * @test
     */
    public function testCommandHasCorrectName()
    {
        $command = new ListManufacturersCommand();
        $this->assertEquals(ListManufacturersCommand::COMMAND_NAME, $command->getName());
    }

    /**
     * @test
     */
    public function testCommandHasCorrectDescription()
    {
        $command = new ListManufacturersCommand();
        $this->assertEquals(ListManufacturersCommand::COMMAND_DESC, $command->getDescription());
    }
}
