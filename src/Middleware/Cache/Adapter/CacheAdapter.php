<?php
/**
 * File: CacheAdapter.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Cache\Adapter;

use Stash\Interfaces\ItemInterface;
use Stash\Interfaces\PoolInterface;

/**
 * Class CacheAdapter
 * @package MSlwk\Otomoto\Middleware\Cache\Adapter
 */
class CacheAdapter implements CacheAdapterInterface
{
    /**
     * @var PoolInterface
     */
    private $pool;

    /**
     * FileAdapterInterface constructor.
     * @param PoolInterface $pool
     */
    public function __construct(
        PoolInterface $pool
    ) {
        $this->pool = $pool;
    }

    /**
     * @param ItemInterface $item
     * @return void
     */
    public function store(ItemInterface $item): void
    {
        $this->pool->save($item);
    }

    /**
     * @param string $path
     * @return ItemInterface
     */
    public function retrieve(string $path): ItemInterface
    {
        return $this->pool->getItem($path);
    }
}
