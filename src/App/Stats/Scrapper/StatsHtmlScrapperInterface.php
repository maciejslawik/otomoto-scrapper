<?php
/**
 * File: StatsHtmlScrapperInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Scrapper;

use MSlwk\Otomoto\App\Stats\Data\StatsDTOInterface;

/**
 * Interface StatsHtmlScrapperInterface
 * @package MSlwk\Otomoto\App\Stats\Scrapper
 */
interface StatsHtmlScrapperInterface
{
    /**
     * @param string $html
     * @return StatsDTOInterface
     */
    public function scrapModelStats(string $html): StatsDTOInterface;
}
