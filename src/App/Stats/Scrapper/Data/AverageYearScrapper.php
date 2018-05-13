<?php
/**
 * File: AverageYearScrapper.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Scrapper\Data;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AverageYearScrapper
 * @package MSlwk\Otomoto\App\Stats\Scrapper\Data
 */
class AverageYearScrapper implements AverageDataScrapperInterface
{
    const HTML_YEAR_SELECTOR = 'li[data-code=year]';

    /**
     * @param Crawler $htmlCrawler
     * @return float
     */
    public function getAverageData(Crawler $htmlCrawler): float
    {
        $yearNode = $htmlCrawler->filter(self::HTML_YEAR_SELECTOR)->first()->getNode(0);
        $yearNodeText = $yearNode->textContent;

        $year = trim($yearNodeText);
        return (int)$year;
    }
}
