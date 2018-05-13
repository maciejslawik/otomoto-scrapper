<?php
/**
 * File: StatsProvider.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTOInterface;
use MSlwk\Otomoto\App\Stats\Data\StatsDTOInterface;
use MSlwk\Otomoto\App\Stats\Filter\FilterArray;
use MSlwk\Otomoto\App\Stats\Scrapper\StatsHtmlScrapperInterface;

/**
 * Class StatsProvider
 * @package MSlwk\Otomoto\App\Stats
 */
class StatsProvider
{
    /**
     * @var ModelOffersHtmlProvider
     */
    private $htmlProvider;

    /**
     * @var StatsHtmlScrapperInterface
     */
    private $htmlScrapper;

    /**
     * StatsProvider constructor.
     * @param ModelOffersHtmlProvider $htmlProvider
     * @param StatsHtmlScrapperInterface $htmlScrapper
     */
    public function __construct(
        ModelOffersHtmlProvider $htmlProvider,
        StatsHtmlScrapperInterface $htmlScrapper
    ) {
        $this->htmlProvider = $htmlProvider;
        $this->htmlScrapper = $htmlScrapper;
    }

    /**
     * @param ManufacturerDTOInterface $manufacturer
     * @param ModelDTOInterface $model
     * @param FilterArray $filters
     * @return StatsDTOInterface
     */
    public function getStats(
        ManufacturerDTOInterface $manufacturer,
        ModelDTOInterface $model,
        FilterArray $filters
    ): StatsDTOInterface {
        $html = $this->htmlProvider->getAllPagesHtml($manufacturer, $model, $filters);
        $stats = $this->htmlScrapper->scrapModelStats($html);
        return $stats;
    }
}
