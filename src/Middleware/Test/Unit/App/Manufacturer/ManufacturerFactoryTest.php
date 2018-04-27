<?php
/**
 * File: ManufacturerFactoryTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\App\Manufacturer;

use MSlwk\Otomoto\Middleware\App\Manufacturer\Manufacturer;
use MSlwk\Otomoto\Middleware\App\Manufacturer\ManufacturerFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class ManufacturerFactoryTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\App\Manufacturer
 */
class ManufacturerFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function testFactoryCreatesCorrectInstance()
    {
        $manufacturerFactory = new ManufacturerFactory();
        $manufacturer = $manufacturerFactory->create();

        $expectedType = Manufacturer::class;
        $this->assertInstanceOf($expectedType, $manufacturer);
    }
}
