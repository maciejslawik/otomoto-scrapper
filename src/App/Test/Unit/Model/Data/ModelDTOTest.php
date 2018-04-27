<?php
/**
 * File: ModelDTOTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Model\Data;

use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use PHPUnit\Framework\TestCase;

/**
 * Class ModelDTOTest
 * @package MSlwk\Otomoto\App\Test\Unit\Model\Data
 */
class ModelDTOTest extends TestCase
{
    /**
     * @return array
     */
    public function nameDataProvider()
    {
        return [
            [
                'A4'
            ],
            [
                'TTRS'
            ],
            [
                'R8'
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
        $manufacturerDTO = new ModelDTO($name);
        $this->assertEquals($name, $manufacturerDTO->getName());
    }
}
