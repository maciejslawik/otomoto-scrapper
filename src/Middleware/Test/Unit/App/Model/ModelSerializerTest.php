<?php
/**
 * File: ModelSerializerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\App\Model;

use PHPUnit\Framework\TestCase;
use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use MSlwk\Otomoto\Middleware\App\Model\ModelSerializer;

/**
 * Class ModelSerializerTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\App\Model
 */
class ModelSerializerTest extends TestCase
{
    /**
     * @var ModelSerializer
     */
    private $serializer;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->serializer = new ModelSerializer();
    }

    /**
     * @test
     */
    public function testSerialize()
    {
        $model1 = new ModelDTO('model1');
        $model2 = new ModelDTO('model2');
        $modelDTOArray = new ModelDTOArray($model1, $model2);

        $expected = 'a:2:{i:0;a:1:{s:4:"name";s:6:"model1";}i:1;a:1:{s:4:"name";s:6:"model2";}}';

        $this->assertEquals($expected, $this->serializer->serialize($modelDTOArray));
    }

    /**
     * @test
     */
    public function testUnserialize()
    {
        $toUnserialize = 'a:2:{i:0;a:1:{s:4:"name";s:6:"model2";}i:1;a:1:{s:4:"name";s:6:"model9";}}';
        $modelDTOArray = $this->serializer->unserialize($toUnserialize);

        $expectedName1 = 'model2';
        $expectedName2 = 'model9';

        $this->assertInstanceOf(ModelDTOArray::class, $modelDTOArray);
        $this->assertEquals($expectedName1, $modelDTOArray->current()->getName());
        $this->assertEquals($expectedName2, $modelDTOArray->get(1)->getName());
    }
}
