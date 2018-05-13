<?php
/**
 * File: AverageDataScrapperInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Scrapper\Data;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Interface AverageDataScrapperInterface
 * @package MSlwk\Otomoto\App\Stats\Scrapper\Data
 */
interface AverageDataScrapperInterface
{
    /**
     * @param Crawler $htmlCrawler
     * @return float
     */
    public function getAverageData(Crawler $htmlCrawler): float;
}
