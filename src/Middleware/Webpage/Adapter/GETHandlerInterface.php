<?php
/**
 * File: GETHandlerInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Adapter;

use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTOArray;

/**
 * Interface GETHandlerInterface
 * @package MSlwk\Otomoto\Middleware\Webpage\Adapter
 */
interface GETHandlerInterface
{
    /**
     * @param UrlDTOArray $urlDTOArray
     * @return WebpageDTOArray
     */
    public function getWebpages(UrlDTOArray $urlDTOArray): WebpageDTOArray;
}
