<?php
/**
 * File: ManufacturerSerializerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\App\Manufacturer;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use MSlwk\Otomoto\Middleware\App\Manufacturer\ManufacturerSerializer;
use PHPUnit\Framework\TestCase;

/**
 * Class ManufacturerSerializerTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\App\Manufacturer
 */
class ManufacturerSerializerTest extends TestCase
{
    /**
     * @var ManufacturerSerializer
     */
    private $manufacturerSerializer;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->manufacturerSerializer = new ManufacturerSerializer();
    }

    /**
     * @test
     */
    public function testSerialize()
    {
        $manufacturer1 = new ManufacturerDTO('manufacturer1');
        $manufacturer2 = new ManufacturerDTO('manufacturer2');
        $manufacturerDTOArray = new ManufacturerDTOArray($manufacturer1, $manufacturer2);

        $expected = 'a:2:{i:0;a:1:{s:4:"name";s:13:"manufacturer1";}i:1;a:1:{s:4:"name";s:13:"manufacturer2";}}';

        $this->assertEquals($expected, $this->manufacturerSerializer->serialize($manufacturerDTOArray));
    }

    /**
     * @test
     */
    public function testUnserialize()
    {
        $toUnserialize = 'a:2:{i:0;a:1:{s:4:"name";s:13:"manufacturer2";}i:1;a:1:{s:4:"name";s:13:"manufacturer9";}}';
        $manufacturerDTOArray = $this->manufacturerSerializer->unserialize($toUnserialize);

        $expectedName1 = 'manufacturer2';
        $expectedName2 = 'manufacturer9';

        $this->assertInstanceOf(ManufacturerDTOArray::class, $manufacturerDTOArray);
        $this->assertEquals($expectedName1, $manufacturerDTOArray->current()->getName());
        $this->assertEquals($expectedName2, $manufacturerDTOArray->get(1)->getName());
    }
}
