<?php
/**
 * File: FileCacheAdapterFactory.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Cache\Factory\File;

use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapter;
use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapterInterface;
use MSlwk\Otomoto\Middleware\Cache\Factory\CacheAdapterFactoryInterface;
use MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider\FileDriverOptionsProviderInterface;
use Stash\Driver\FileSystem;
use Stash\Pool;

/**
 * Class FileCacheAdapterFactory
 * @package MSlwk\Otomoto\Middleware\Cache\Factory
 */
class FileCacheAdapterFactory implements CacheAdapterFactoryInterface
{
    /**
     * @var FileDriverOptionsProviderInterface
     */
    private $fileDriverOptionsProvider;

    /**
     * FileCacheAdapterFactory constructor.
     * @param FileDriverOptionsProviderInterface $fileDriverOptionsProvider
     */
    public function __construct(
        FileDriverOptionsProviderInterface $fileDriverOptionsProvider
    ) {
        $this->fileDriverOptionsProvider = $fileDriverOptionsProvider;
    }

    /**
     * @return CacheAdapterInterface
     */
    public function createAdapter(): CacheAdapterInterface
    {
        $driver = new FileSystem($this->fileDriverOptionsProvider->getOptions());
        $pool = new Pool($driver);
        return new CacheAdapter($pool);
    }
}
