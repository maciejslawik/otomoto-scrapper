<?php
/**
 * File: Pager.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Pager;

/**
 * Class Pager
 * @package MSlwk\Otomoto\App\Stats\Pager
 */
class Pager implements PagerInterface
{
    /**
     * @param int $page
     * @return string
     */
    public function getPagerParameter(int $page): string
    {
        return "page={$page}";
    }
}
