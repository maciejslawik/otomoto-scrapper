<?php
/**
 * File: ManufacturerDTOArrayTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Manufacturer\Data;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use PHPUnit\Framework\TestCase;

/**
 * Class ManufacturerDTOArrayTest
 * @package MSlwk\Otomoto\App\Test\Unit\Manufacturer\Data
 */
class ManufacturerDTOArrayTest extends TestCase
{
    /**
     * @return array
     */
    public function namesDataProvider()
    {
        return [
            [
                'Audi',
                'BMW'
            ],
            [
                'BMW',
                'Volkswagen'
            ],
            [
                'Lexus',
                'Nissan'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstManufacturerName
     * @param $secondManufacturerName
     */
    public function testGetManufacturersAddedViaConstructor($firstManufacturerName, $secondManufacturerName)
    {
        $firstManufacturer = new ManufacturerDTO($firstManufacturerName);
        $secondManufacturer = new ManufacturerDTO($secondManufacturerName);

        $manufacturerDTOArray = new ManufacturerDTOArray($firstManufacturer, $secondManufacturer);

        $this->assertEquals($firstManufacturerName, $manufacturerDTOArray->get(0)->getName());
        $this->assertEquals($secondManufacturerName, $manufacturerDTOArray->get(1)->getName());
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstManufacturerName
     * @param $secondManufacturerName
     */
    public function testGetManufacturersAddedViaAdd($firstManufacturerName, $secondManufacturerName)
    {
        $firstManufacturer = new ManufacturerDTO($firstManufacturerName);
        $secondManufacturer = new ManufacturerDTO($secondManufacturerName);

        $manufacturerDTOArray = new ManufacturerDTOArray();
        $manufacturerDTOArray->add($firstManufacturer);
        $manufacturerDTOArray->add($secondManufacturer);

        $this->assertEquals($firstManufacturerName, $manufacturerDTOArray->get(0)->getName());
        $this->assertEquals($secondManufacturerName, $manufacturerDTOArray->get(1)->getName());
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstManufacturerName
     * @param $secondManufacturerName
     */
    public function testGetManufacturersAddedViaSet($firstManufacturerName, $secondManufacturerName)
    {
        $firstManufacturer = new ManufacturerDTO($firstManufacturerName);
        $secondManufacturer = new ManufacturerDTO($secondManufacturerName);

        $manufacturerDTOArray = new ManufacturerDTOArray();
        $manufacturerDTOArray->set(2, $firstManufacturer);
        $manufacturerDTOArray->set(1, $secondManufacturer);

        $this->assertEquals($firstManufacturerName, $manufacturerDTOArray->get(2)->getName());
        $this->assertEquals($secondManufacturerName, $manufacturerDTOArray->get(1)->getName());
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstManufacturerName
     * @param $secondManufacturerName
     */
    public function testCurrent($firstManufacturerName, $secondManufacturerName)
    {
        $firstManufacturer = new ManufacturerDTO($firstManufacturerName);
        $secondManufacturer = new ManufacturerDTO($secondManufacturerName);

        $manufacturerDTOArray = new ManufacturerDTOArray($firstManufacturer, $secondManufacturer);

        $this->assertEquals($firstManufacturerName, $manufacturerDTOArray->current()->getName());
        $manufacturerDTOArray->next();
        $this->assertEquals($secondManufacturerName, $manufacturerDTOArray->current()->getName());
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstManufacturerName
     * @param $secondManufacturerName
     */
    public function testCount($firstManufacturerName, $secondManufacturerName)
    {
        $firstManufacturer = new ManufacturerDTO($firstManufacturerName);
        $secondManufacturer = new ManufacturerDTO($secondManufacturerName);

        $manufacturerDTOArray = new ManufacturerDTOArray($firstManufacturer, $secondManufacturer);

        $this->assertEquals(2, $manufacturerDTOArray->count());
    }
}
