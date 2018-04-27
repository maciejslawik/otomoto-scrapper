<?php
/**
 * File: ModelTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\App\Model;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use MSlwk\Otomoto\App\Model\ModelProvider;
use MSlwk\Otomoto\Middleware\App\Model\Model;
use MSlwk\Otomoto\Middleware\App\Model\ModelSerializer;
use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stash\Interfaces\ItemInterface;

/**
 * Class ModelTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\App\Model
 */
class ModelTest extends TestCase
{
    /**
     * @var MockObject|CacheAdapter
     */
    private $cacheAdapter;

    /**
     * @var MockObject|ModelProvider
     */
    private $modelProvider;

    /**
     * @var MockObject|ModelSerializer
     */
    private $modelSerializer;

    /**
     * @var Model
     */
    private $modelMiddleware;

    /**
     * @var MockObject|ItemInterface
     */
    private $cacheItem;

    /**
     * @var ManufacturerDTO
     */
    private $manufacturer;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->manufacturer = new ManufacturerDTO('manufacturer');

        $this->cacheAdapter = $this->getMockBuilder(CacheAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->cacheItem = $this->getMockBuilder(ItemInterface::class)
            ->getMock();
        $this->cacheAdapter->expects($this->atLeastOnce())
            ->method('retrieve')
            ->with('models_manufacturer')
            ->will($this->returnValue($this->cacheItem));
        $this->modelProvider = $this->getMockBuilder(ModelProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->modelSerializer = $this->getMockBuilder(ModelSerializer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->modelSerializer->expects($this->once())
            ->method('unserialize')
            ->will($this->returnValue(new ModelDTOArray()));

        $this->modelMiddleware = new Model(
            $this->cacheAdapter,
            $this->modelProvider,
            $this->modelSerializer
        );
    }

    /**
     * @test
     */
    public function testMiddlewareReturnsModelsFromCache()
    {
        $this->cacheItem->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnValue('a:1:{i:0;a:1:{s:4:"name";s:6:"model1";}}'));

        $result = $this->modelMiddleware->getModels($this->manufacturer);
        $expectedType = ModelDTOArray::class;

        $this->assertInstanceOf($expectedType, $result);
    }

    /**
     * @test
     */
    public function testMiddlewareReturnsModelsFromRequest()
    {
        $this->cacheItem->expects($this->exactly(2))
            ->method('get')
            ->willReturnOnConsecutiveCalls(
                null,
                'a:1:{i:0;a:1:{s:4:"name";s:6:"model1";}}'
            );

        $result = $this->modelMiddleware->getModels($this->manufacturer);
        $expectedType = ModelDTOArray::class;

        $this->assertInstanceOf($expectedType, $result);
    }
}
