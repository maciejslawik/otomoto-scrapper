<?php
/**
 * File: UrlPoviderInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Base;

/**
 * Interface UrlPoviderInterface
 * @package MSlwk\Otomoto\App\Base
 */
interface UrlPoviderInterface
{
    /**
     * @return string
     */
    public function getBaseUrl(): string;
}
