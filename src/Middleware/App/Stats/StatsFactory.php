<?php
/**
 * File: StatsFactory.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\App\Stats;

use MSlwk\Otomoto\App\Base\UrlProvider;
use MSlwk\Otomoto\App\Manufacturer\Url\ManufacturerUrlSuffixProvider;
use MSlwk\Otomoto\App\Model\Url\ModelUrlSuffixProvider;
use MSlwk\Otomoto\App\Stats\ModelOffersHtmlProvider;
use MSlwk\Otomoto\App\Stats\Pager\Pager;
use MSlwk\Otomoto\App\Stats\Scrapper\Data\AverageMileageScrapper;
use MSlwk\Otomoto\App\Stats\Scrapper\Data\AveragePriceScrapper;
use MSlwk\Otomoto\App\Stats\Scrapper\Data\AverageYearScrapper;
use MSlwk\Otomoto\App\Stats\Scrapper\StatsHtmlScrapper;
use MSlwk\Otomoto\App\Stats\StatsProvider;
use MSlwk\Otomoto\Middleware\Slugify\CocurSlugifyAdapter;
use MSlwk\Otomoto\Middleware\Webpage\Factory\ReactPHP\ReactPHPAdapterFactory;

/**
 * Class StatsFactory
 * @package MSlwk\Otomoto\Middleware\App\Stats
 */
class StatsFactory
{
    /**
     * @return Stats
     */
    public function create(): Stats
    {
        return new Stats($this->getStatsProvider());
    }

    /**
     * @return StatsProvider
     */
    private function getStatsProvider(): StatsProvider
    {
        $htmlProvider = $this->getHtmlProvider();
        $statsHtmlScrapper = $this->getHtmlScrapper();
        $statsProvider = new StatsProvider($htmlProvider, $statsHtmlScrapper);
        return $statsProvider;
    }

    /**
     * @return ModelOffersHtmlProvider
     */
    private function getHtmlProvider(): ModelOffersHtmlProvider
    {
        $adapterFactory = new ReactPHPAdapterFactory();
        $urlProvider = new UrlProvider();
        $slugifier = new CocurSlugifyAdapter();
        $manufacuterUrlSuffixProvider = new ManufacturerUrlSuffixProvider($slugifier);
        $modelUrlSuffixProvider = new ModelUrlSuffixProvider($slugifier);
        $pager = new Pager();
        $htmlProvider = new ModelOffersHtmlProvider(
            $adapterFactory,
            $urlProvider,
            $manufacuterUrlSuffixProvider,
            $modelUrlSuffixProvider,
            $pager
        );
        return $htmlProvider;
    }

    /**
     * @return StatsHtmlScrapper
     */
    private function getHtmlScrapper(): StatsHtmlScrapper
    {
        $mileageScrapper = new AverageMileageScrapper();
        $priceScrapper = new AveragePriceScrapper();
        $yearScrapper = new AverageYearScrapper();
        $statsHtmlScrapper = new StatsHtmlScrapper(
            $mileageScrapper,
            $yearScrapper,
            $priceScrapper
        );
        return $statsHtmlScrapper;
    }
}
