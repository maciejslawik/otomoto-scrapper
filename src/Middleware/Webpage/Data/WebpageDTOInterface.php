<?php
/**
 * File: WebpageDTOInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Data;

/**
 * Interface WebpageDTOInterface
 * @package MSlwk\Otomoto\Middleware\Webpage\Data
 */
interface WebpageDTOInterface
{
    /**
     * @return string
     */
    public function getHtml(): string;
}