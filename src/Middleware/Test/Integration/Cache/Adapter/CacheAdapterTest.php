<?php
/**
 * File: CacheAdapterTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Integration\Cache\Adapter;

use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapterInterface;
use MSlwk\Otomoto\Middleware\Cache\Factory\File\FileCacheAdapterFactory;
use MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider\FileDriverOptionsProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class CacheAdapterTest
 * @package MSlwk\Otomoto\Middleware\Test\Integration\Cache\Adapter
 */
class CacheAdapterTest extends TestCase
{
    /**
     * @var CacheAdapterInterface
     */
    private $cacheAdapter;

    /**
     * @return void
     */
    public function setUp()
    {
        $optionsProvider = new FileDriverOptionsProvider();
        $cacheAdapterFactory = new FileCacheAdapterFactory($optionsProvider);
        $this->cacheAdapter = $cacheAdapterFactory->createAdapter();
    }

    /**
     * @return array
     */
    public function cacheDataProvider()
    {
        return [
            [
                'key_1',
                'value_1'
            ],
            [
                'key_2',
                'value_2'
            ],
            [
                'key_3',
                'value_3'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider cacheDataProvider
     * @param $key
     * @param $value
     */
    public function testCacheKeyStoredCorrectlyInFilesystem($key, $value)
    {
        $optionsProvider = new FileDriverOptionsProvider();
        $cacheAdapterFactory = new FileCacheAdapterFactory($optionsProvider);
        $cacheAdapter = $cacheAdapterFactory->createAdapter();

        $cacheItem = $cacheAdapter->retrieve($key);
        $this->assertEmpty($cacheItem->get());

        $cacheItem->set($value);
        $cacheAdapter->store($cacheItem);

        $cacheItem = $cacheAdapter->retrieve($key);
        $this->assertEquals($value, $cacheItem->get());

        $cacheItem->set(null);
        $cacheAdapter->store($cacheItem);

        $cacheItem = $cacheAdapter->retrieve($key);
        $this->assertEmpty($cacheItem->get());
    }
}
