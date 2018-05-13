<?php
/**
 * File: AveragePriceScrapper.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Scrapper\Data;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AveragePriceScrapper
 * @package MSlwk\Otomoto\App\Stats\Scrapper\Data
 */
class AveragePriceScrapper implements AverageDataScrapperInterface
{
    const HTML_PRICE_SELECTOR = 'span.offer-price__number';
    const HTML_PRICE_DETAILS_SELECTOR = 'span.offer-price__details';
    const HTML_PRICE_NET_SYMBOL = 'Netto';
    const CAR_PRICE_TAX = 1.23;

    /**
     * @param Crawler $htmlCrawler
     * @return float
     */
    public function getAverageData(Crawler $htmlCrawler): float
    {
        $priceValueNode = $htmlCrawler->filter(self::HTML_PRICE_SELECTOR)->first()->getNode(0);
        $priceValueNodeText = $priceValueNode->textContent;
        $price = (float)str_replace(' ', '', trim($priceValueNodeText));

        $priceDetailsNode = $htmlCrawler->filter(self::HTML_PRICE_DETAILS_SELECTOR)->first()->getNode(0);
        $priceValueNodeText = $priceDetailsNode->textContent;
        if (strpos($priceValueNodeText, self::HTML_PRICE_NET_SYMBOL) !== false) {
            $price = $price * self::CAR_PRICE_TAX;
        }

        return $price;
    }
}
