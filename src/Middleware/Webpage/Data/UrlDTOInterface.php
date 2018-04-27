<?php
/**
 * File: UrlDTOInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Data;

/**
 * Interface UrlDTOInterface
 * @package MSlwk\Otomoto\Middleware\Webpage\Data
 */
interface UrlDTOInterface
{
    /**
     * @return string
     */
    public function getUrl(): string;
}
