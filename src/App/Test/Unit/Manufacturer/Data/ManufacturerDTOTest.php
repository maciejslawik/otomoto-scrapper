<?php
/**
 * File: ManufacturerDTOTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Manufacturer\Data;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use PHPUnit\Framework\TestCase;

/**
 * Class ManufacturerDTOTest
 * @package MSlwk\Otomoto\App\Test\Unit\Manufacturer\Data
 */
class ManufacturerDTOTest extends TestCase
{
    /**
     * @return array
     */
    public function nameDataProvider()
    {
        return [
            [
                'Audi'
            ],
            [
                'BMW'
            ],
            [
                'Lexus'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider nameDataProvider
     * @param $name
     */
    public function testGetName($name)
    {
        $manufacturerDTO = new ManufacturerDTO($name);
        $this->assertEquals($name, $manufacturerDTO->getName());
    }
}
