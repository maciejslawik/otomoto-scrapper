<?php
/**
 * File: Model.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\App\Model;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use MSlwk\Otomoto\App\Model\ModelProvider;
use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapterInterface;

/**
 * Class Model
 * @package MSlwk\Otomoto\Middleware\App\Model
 */
class Model
{
    const CACHE_TAG = 'models_%manufacturer%';

    /**
     * @var CacheAdapterInterface
     */
    private $cacheAdapter;

    /**
     * @var ModelProvider
     */
    private $modelProvider;

    /**
     * @var ModelSerializer
     */
    private $modelSerializer;


    /**
     * Model constructor.
     * @param CacheAdapterInterface $cacheAdapter
     * @param ModelProvider $modelProvider
     * @param ModelSerializer $modelSerializer
     */
    public function __construct(
        CacheAdapterInterface $cacheAdapter,
        ModelProvider $modelProvider,
        ModelSerializer $modelSerializer
    ) {
        $this->cacheAdapter = $cacheAdapter;
        $this->modelProvider = $modelProvider;
        $this->modelSerializer = $modelSerializer;
    }

    /**
     * @param ManufacturerDTOInterface $manufacturerDTO
     * @return ModelDTOArray
     */
    public function getModels(ManufacturerDTOInterface $manufacturerDTO): ModelDTOArray
    {
        $cacheItem = $this->cacheAdapter->retrieve($this->getCacheTag($manufacturerDTO));
        if (!$cacheItem->get()) {
            $models = $this->modelProvider->getModels($manufacturerDTO);
            $cacheItem->set($this->modelSerializer->serialize($models));
            $this->cacheAdapter->store($cacheItem);
            $cacheItem = $this->cacheAdapter->retrieve($this->getCacheTag($manufacturerDTO));
        }

        return $this->modelSerializer->unserialize($cacheItem->get());
    }

    /**
     * @param ManufacturerDTOInterface $manufacturerDTO
     * @return string
     */
    private function getCacheTag(ManufacturerDTOInterface $manufacturerDTO): string
    {
        return str_replace('%manufacturer%', $manufacturerDTO->getName(), self::CACHE_TAG);
    }
}
