<?php
/**
 * File: CacheAdapterInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Cache\Adapter;

use Stash\Interfaces\ItemInterface;

/**
 * Interface CacheAdapterInterface
 * @package MSlwk\Otomoto\Middleware\Cache\Adapter
 */
interface CacheAdapterInterface
{
    /**
     * @param ItemInterface $item
     */
    public function store(ItemInterface $item): void;

    /**
     * @param string $path
     * @return ItemInterface
     */
    public function retrieve(string $path): ItemInterface;
}
