<?php
/**
 * File: ModelDTOArrayTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Model\Data;

use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use PHPUnit\Framework\TestCase;

/**
 * Class ModelDTOArrayTest
 * @package MSlwk\Otomoto\App\Test\Unit\Model\Data
 */
class ModelDTOArrayTest extends TestCase
{
    /**
     * @return array
     */
    public function namesDataProvider()
    {
        return [
            [
                'A6',
                'TTRS'
            ],
            [
                'Megane',
                'Talisman'
            ],
            [
                'Giulia',
                'Giulietta'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstModelName
     * @param $secondModelName
     */
    public function testGetModelsAddedViaConstructor($firstModelName, $secondModelName)
    {
        $firstModel = new ModelDTO($firstModelName);
        $secondModel = new ModelDTO($secondModelName);

        $modelDTOArray = new ModelDTOArray($firstModel, $secondModel);

        $this->assertEquals($firstModelName, $modelDTOArray->get(0)->getName());
        $this->assertEquals($secondModelName, $modelDTOArray->get(1)->getName());
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstModelName
     * @param $secondModelName
     */
    public function testGetModelsAddedViaAdd($firstModelName, $secondModelName)
    {
        $firstModel = new ModelDTO($firstModelName);
        $secondModel = new ModelDTO($secondModelName);

        $modelDTOArray = new ModelDTOArray();
        $modelDTOArray->add($firstModel);
        $modelDTOArray->add($secondModel);

        $this->assertEquals($firstModelName, $modelDTOArray->get(0)->getName());
        $this->assertEquals($secondModelName, $modelDTOArray->get(1)->getName());
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstModelName
     * @param $secondModelName
     */
    public function testGetModelsAddedViaSet($firstModelName, $secondModelName)
    {
        $firstModel = new ModelDTO($firstModelName);
        $secondModel = new ModelDTO($secondModelName);

        $modelDTOArray = new ModelDTOArray();
        $modelDTOArray->set(2, $firstModel);
        $modelDTOArray->set(1, $secondModel);

        $this->assertEquals($firstModelName, $modelDTOArray->get(2)->getName());
        $this->assertEquals($secondModelName, $modelDTOArray->get(1)->getName());
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstModelName
     * @param $secondModelName
     */
    public function testCurrent($firstModelName, $secondModelName)
    {
        $firstModel = new ModelDTO($firstModelName);
        $secondModel = new ModelDTO($secondModelName);

        $modelDTOArray = new ModelDTOArray($firstModel, $secondModel);

        $this->assertEquals($firstModelName, $modelDTOArray->current()->getName());
        $modelDTOArray->next();
        $this->assertEquals($secondModelName, $modelDTOArray->current()->getName());
    }

    /**
     * @test
     * @dataProvider namesDataProvider
     * @param $firstModelName
     * @param $secondModelName
     */
    public function testCount($firstModelName, $secondModelName)
    {
        $firstModel = new ModelDTO($firstModelName);
        $secondModel = new ModelDTO($secondModelName);

        $modelDTOArray = new ModelDTOArray($firstModel, $secondModel);

        $this->assertEquals(2, $modelDTOArray->count());
    }
}
