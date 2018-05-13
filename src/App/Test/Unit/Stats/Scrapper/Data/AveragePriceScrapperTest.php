<?php
declare(strict_types=1);

/**
 * File:AveragePriceScrapperTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Scrapper\Data;

use MSlwk\Otomoto\App\Stats\Scrapper\Data\AveragePriceScrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AveragePriceScrapperTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Scrapper\Data
 */
class AveragePriceScrapperTest extends TestCase
{
    use OfferHtmlTrait;

    /**
     * @test
     */
    public function testGetPrice()
    {
        $crawler = new Crawler($this->getOfferHtml());
        $scrapper = new AveragePriceScrapper();

        $expected = 281670.0;
        $result = $scrapper->getAverageData($crawler);

        $this->assertEquals($expected, $result);
    }
}
