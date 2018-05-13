<?php
declare(strict_types=1);

/**
 * File:StatsProviderTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTOInterface;
use MSlwk\Otomoto\App\Stats\Data\StatsDTOInterface;
use MSlwk\Otomoto\App\Stats\Filter\FilterArray;
use MSlwk\Otomoto\App\Stats\ModelOffersHtmlProvider;
use MSlwk\Otomoto\App\Stats\Scrapper\StatsHtmlScrapperInterface;
use MSlwk\Otomoto\App\Stats\StatsProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class StatsProviderTest
 * @package MSlwk\Otomoto\App\Stats
 */
class StatsProviderTest extends TestCase
{
    /**
     * @test
     */
    public function testGetStats()
    {
        /** @var MockObject|ManufacturerDTOInterface $manufacturer */
        $manufacturer = $this->getMockBuilder(ManufacturerDTOInterface::class)
            ->getMock();
        /** @var MockObject|ModelDTOInterface $model */
        $model = $this->getMockBuilder(ModelDTOInterface::class)
            ->getMock();
        /** @var MockObject|FilterArray $filters */
        $filters = $this->getMockBuilder(FilterArray::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stats = $this->getMockBuilder(StatsDTOInterface::class)
            ->getMock();
        $html = '<html></html>';

        /** @var MockObject|ModelOffersHtmlProvider $modelOfferHtmlProvider */
        $modelOfferHtmlProvider = $this->getMockBuilder(ModelOffersHtmlProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $modelOfferHtmlProvider->expects($this->once())
            ->method('getAllPagesHtml')
            ->with($manufacturer, $model, $filters)
            ->will($this->returnValue($html));
        /** @var MockObject|StatsHtmlScrapperInterface $statsHtmlScrapper */
        $statsHtmlScrapper = $this->getMockBuilder(StatsHtmlScrapperInterface::class)
            ->getMock();
        $statsHtmlScrapper->expects($this->once())
            ->method('scrapModelStats')
            ->with($html)
            ->will($this->returnValue($stats));

        $statsProvider = new StatsProvider($modelOfferHtmlProvider, $statsHtmlScrapper);

        $this->assertEquals($stats, $statsProvider->getStats($manufacturer, $model, $filters));
    }
}
