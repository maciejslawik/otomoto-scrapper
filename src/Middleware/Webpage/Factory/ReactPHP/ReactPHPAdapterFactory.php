<?php
/**
 * File: ReactPHPAdapterFactory.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Factory\ReactPHP;

use MSlwk\Otomoto\Middleware\Webpage\Adapter\GETHandlerInterface;
use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ClientFactory;
use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ReactPHPRequestAdapter;
use MSlwk\Otomoto\Middleware\Webpage\Factory\GETHandlerAdapterFactoryInterface;
use React\EventLoop\Factory;

/**
 * Class ReactPHPAdapterFactory
 * @package MSlwk\Otomoto\Middleware\Webpage\Factory\ReactPHP
 */
class ReactPHPAdapterFactory implements GETHandlerAdapterFactoryInterface
{
    /**
     * @return GetHandlerInterface
     */
    public function create(): GETHandlerInterface
    {
        return new ReactPHPRequestAdapter(Factory::create(), new ClientFactory());
    }
}
