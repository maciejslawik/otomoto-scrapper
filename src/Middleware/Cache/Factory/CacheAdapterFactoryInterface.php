<?php
/**
 * File: CacheAdapterFactoryInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Cache\Factory;

use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapterInterface;

/**
 * Interface CacheAdapterFactoryInterface
 * @package MSlwk\Otomoto\Middleware\Cache\Factory
 */
interface CacheAdapterFactoryInterface
{
    /**
     * @return CacheAdapterInterface
     */
    public function createAdapter(): CacheAdapterInterface;
}
