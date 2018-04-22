<?php
/**
 * File: GETHandlerAdapterFactoryInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Factory;

use MSlwk\Otomoto\Middleware\Webpage\Adapter\GETHandlerInterface;

/**
 * Interface GETHandlerAdapterFactoryInterface
 * @package MSlwk\Otomoto\Middleware\Webpage\Factory
 */
interface GETHandlerAdapterFactoryInterface
{
    /**
     * @return GETHandlerInterface
     */
    public function create(): GETHandlerInterface;
}
