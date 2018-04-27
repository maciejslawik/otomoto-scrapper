<?php
/**
 * File: ManufacturerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\App\Manufacturer;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use MSlwk\Otomoto\App\Manufacturer\ManufacturerProvider;
use MSlwk\Otomoto\Middleware\App\Manufacturer\Manufacturer;
use MSlwk\Otomoto\Middleware\App\Manufacturer\ManufacturerSerializer;
use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stash\Interfaces\ItemInterface;

/**
 * Class ManufacturerTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\App\Manufacturer
 */
class ManufacturerTest extends TestCase
{
    /**
     * @var MockObject|CacheAdapter
     */
    private $cacheAdapter;

    /**
     * @var MockObject|ManufacturerProvider
     */
    private $manufacturerProvider;

    /**
     * @var MockObject|ManufacturerSerializer
     */
    private $manufacturerSerializer;

    /**
     * @var Manufacturer
     */
    private $manufacturerMiddleware;

    /**
     * @var MockObject|ItemInterface
     */
    private $cacheItem;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->cacheAdapter = $this->getMockBuilder(CacheAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->cacheItem = $this->getMockBuilder(ItemInterface::class)
            ->getMock();
        $this->cacheAdapter->expects($this->atLeastOnce())
            ->method('retrieve')
            ->will($this->returnValue($this->cacheItem));
        $this->manufacturerProvider = $this->getMockBuilder(ManufacturerProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->manufacturerSerializer = $this->getMockBuilder(ManufacturerSerializer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->manufacturerSerializer->expects($this->once())
            ->method('unserialize')
            ->will($this->returnValue(new ManufacturerDTOArray()));

        $this->manufacturerMiddleware = new Manufacturer(
            $this->cacheAdapter,
            $this->manufacturerProvider,
            $this->manufacturerSerializer
        );
    }

    /**
     * @test
     */
    public function testMiddlewareReturnsManufacturersFromCache()
    {
        $this->cacheItem->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnValue('a:1:{i:0;a:1:{s:4:"name";s:13:"manufacturer1";}}'));

        $result = $this->manufacturerMiddleware->getManufacturers();
        $expectedType = ManufacturerDTOArray::class;

        $this->assertInstanceOf($expectedType, $result);
    }

    /**
     * @test
     */
    public function testMiddlewareReturnsManufacturersFromRequest()
    {
        $this->cacheItem->expects($this->exactly(2))
            ->method('get')
            ->willReturnOnConsecutiveCalls(
                null,
                'a:1:{i:0;a:1:{s:4:"name";s:13:"manufacturer1";}}'
            );

        $result = $this->manufacturerMiddleware->getManufacturers();
        $expectedType = ManufacturerDTOArray::class;

        $this->assertInstanceOf($expectedType, $result);
    }
}
