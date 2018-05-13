<?php
/**
 * File: AverageMileageScrapper.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Scrapper\Data;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AverageMileageScrapper
 * @package MSlwk\Otomoto\App\Stats\Scrapper\Data
 */
class AverageMileageScrapper implements AverageDataScrapperInterface
{
    const HTML_MILEAGE_SELECTOR = 'li[data-code=mileage]';

    /**
     * @param Crawler $htmlCrawler
     * @return float
     */
    public function getAverageData(Crawler $htmlCrawler): float
    {
        $mileageNode = $htmlCrawler->filter(self::HTML_MILEAGE_SELECTOR)->first()->getNode(0);
        if ($mileageNode) {
            $mileageNodeText = $mileageNode->textContent;
        } else {
            $mileageNodeText = '1';
        }

        $mileage = str_replace(' ', '', rtrim(trim($mileageNodeText), 'km'));
        return (float)$mileage;
    }
}
