<?php
/**
 * File: Manufacturer.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\App\Manufacturer;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use MSlwk\Otomoto\App\Manufacturer\ManufacturerProvider;
use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapterInterface;

/**
 * Class Manufacturer
 * @package MSlwk\Otomoto\Middleware
 */
class Manufacturer
{
    const CACHE_TAG = 'manufacturers';

    /**
     * @var CacheAdapterInterface
     */
    private $cacheAdapter;

    /**
     * @var ManufacturerProvider
     */
    private $manufacturerProvider;

    /**
     * @var ManufacturerSerializer
     */
    private $manufacturerSerializer;

    /**
     * Manufacturer constructor.
     * @param CacheAdapterInterface $cacheAdapter
     * @param ManufacturerProvider $manufacturerProvider
     * @param ManufacturerSerializer $manufacturerSerializer
     */
    public function __construct(
        CacheAdapterInterface $cacheAdapter,
        ManufacturerProvider $manufacturerProvider,
        ManufacturerSerializer $manufacturerSerializer
    ) {
        $this->cacheAdapter = $cacheAdapter;
        $this->manufacturerProvider = $manufacturerProvider;
        $this->manufacturerSerializer = $manufacturerSerializer;
    }

    /**
     * @return ManufacturerDTOArray
     */
    public function getManufacturers(): ManufacturerDTOArray
    {
        $cacheItem = $this->cacheAdapter->retrieve(self::CACHE_TAG);
        if (!$cacheItem->get()) {
            $manufacturers = $this->manufacturerProvider->getManufacturers();
            $cacheItem->set($this->manufacturerSerializer->serialize($manufacturers));
            $this->cacheAdapter->store($cacheItem);
            $cacheItem = $this->cacheAdapter->retrieve(self::CACHE_TAG);
        }

        return $this->manufacturerSerializer->unserialize($cacheItem->get());
    }
}
