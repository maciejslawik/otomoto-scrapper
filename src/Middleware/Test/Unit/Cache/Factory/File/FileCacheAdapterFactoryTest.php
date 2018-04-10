<?php
/**
 * File: FileCacheAdapterFactoryTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Cache\Factory\File;

use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapterInterface;
use MSlwk\Otomoto\Middleware\Cache\Factory\File\FileCacheAdapterFactory;
use MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider\FileDriverOptionsProviderInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class FileCacheAdapterFactoryTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Cache\Factory\File
 */
class FileCacheAdapterFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function testCreateAdapterReturnsAdapter()
    {
        /** @var FileDriverOptionsProviderInterface $optionsProvider */
        $optionsProvider = $this->getMockBuilder(FileDriverOptionsProviderInterface::class)
            ->setMethods(['getOptions'])
            ->getMock();
        $factory = new FileCacheAdapterFactory($optionsProvider);
        $this->assertInstanceOf(CacheAdapterInterface::class, $factory->createAdapter());
    }
}
