<?php
/**
 * File: PagerInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Pager;

/**
 * Interface PagerInterface
 * @package MSlwk\Otomoto\App\Stats\Pager
 */
interface PagerInterface
{
    /**
     * @param int $page
     * @return string
     */
    public function getPagerParameter(int $page): string;
}
