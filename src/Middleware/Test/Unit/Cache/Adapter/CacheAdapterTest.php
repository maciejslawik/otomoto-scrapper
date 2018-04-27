<?php
/**
 * File: CacheAdapterTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Adapter;

use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapter;
use PHPUnit\Framework\TestCase;
use Stash\Interfaces\ItemInterface;
use Stash\Interfaces\PoolInterface;

/**
 * Class CacheAdapterTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Adapter
 */
class CacheAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function testStoreItem()
    {
        $pool = $this->getMockBuilder(PoolInterface::class)
            ->getMock();
        $pool->expects($this->once())
            ->method('save');

        $item = $this->getMockBuilder(ItemInterface::class)
            ->getMock();

        $cacheAdapter = new CacheAdapter($pool);
        $cacheAdapter->store($item);
    }

    /**
     * @test
     */
    public function testRetrieveItem()
    {
        $item = $this->getMockBuilder(ItemInterface::class)
            ->getMock();

        $pool = $this->getMockBuilder(PoolInterface::class)
            ->getMock();
        $pool->expects($this->once())
            ->method('getItem')
            ->will($this->returnValue($item));

        $cacheAdapter = new CacheAdapter($pool);

        $this->assertInstanceOf(ItemInterface::class, $cacheAdapter->retrieve('test_path'));
    }
}
