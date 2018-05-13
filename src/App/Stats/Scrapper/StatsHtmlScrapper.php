<?php
/**
 * File: StatsHtmlScrapper.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Scrapper;

use MSlwk\Otomoto\App\Exception\OffersNotFoundException;
use MSlwk\Otomoto\App\Stats\Data\StatsDTO;
use MSlwk\Otomoto\App\Stats\Data\StatsDTOInterface;
use MSlwk\Otomoto\App\Stats\Scrapper\Data\AverageDataScrapperInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class StatsHtmlScrapper
 * @package MSlwk\Otomoto\App\Stats\Scrapper
 */
class StatsHtmlScrapper implements StatsHtmlScrapperInterface
{
    const HTML_OFFER_SELECTOR = 'article.offer-item.is-row';

    /**
     * @var AverageDataScrapperInterface
     */
    private $mileageScrapper;

    /**
     * @var AverageDataScrapperInterface
     */
    private $yearScrapper;

    /**
     * @var AverageDataScrapperInterface
     */
    private $priceScrapper;

    /**
     * @var array
     */
    private $mileages = [];

    /**
     * @var array
     */
    private $prices = [];

    /**
     * @var array
     */
    private $years = [];

    /**
     * StatsHtmlScrapper constructor.
     * @param AverageDataScrapperInterface $mileageScrapper
     * @param AverageDataScrapperInterface $yearScrapper
     * @param AverageDataScrapperInterface $priceScrapper
     */
    public function __construct(
        AverageDataScrapperInterface $mileageScrapper,
        AverageDataScrapperInterface $yearScrapper,
        AverageDataScrapperInterface $priceScrapper
    ) {
        $this->mileageScrapper = $mileageScrapper;
        $this->yearScrapper = $yearScrapper;
        $this->priceScrapper = $priceScrapper;
    }

    /**
     * @param string $html
     * @return StatsDTOInterface
     */
    public function scrapModelStats(string $html): StatsDTOInterface
    {
        $crawler = new Crawler($html);
        $carInstances = $crawler->filter(self::HTML_OFFER_SELECTOR);

        $carInstances->each(function (Crawler $crawler) use (&$mileages, &$prices, &$years) {
            $this->mileages[] = $this->mileageScrapper->getAverageData($crawler);
            $this->prices[] = $this->priceScrapper->getAverageData($crawler);
            $this->years[] = $this->yearScrapper->getAverageData($crawler);
        });

        $stats = $this->getAverageStats($this->mileages, $this->prices, $this->years);

        return $stats;
    }

    /**
     * @param $mileages
     * @param $prices
     * @param $years
     * @return StatsDTOInterface
     * @throws OffersNotFoundException
     */
    private function getAverageStats(array $mileages, array $prices, array $years): StatsDTOInterface
    {
        $stats = new StatsDTO();

        if (!$this->offersFound()) {
            throw new OffersNotFoundException('No offers were found');
        }
        $stats->setAverageMileage(array_sum($mileages) / count($mileages));
        $stats->setAveragePrice(array_sum($prices) / count($prices));
        $stats->setAverageYear(array_sum($years) / count($years));
        return $stats;
    }

    /**
     * @return bool
     */
    private function offersFound(): bool
    {
        return count($this->mileages) && count($this->prices) && count($this->years);
    }
}
