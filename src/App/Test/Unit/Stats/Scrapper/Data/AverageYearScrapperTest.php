<?php
declare(strict_types=1);

/**
 * File:AverageYearScrapperTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Scrapper\Data;

use MSlwk\Otomoto\App\Stats\Scrapper\Data\AverageYearScrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AverageYearScrapperTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Scrapper\Data
 */
class AverageYearScrapperTest extends TestCase
{
    use OfferHtmlTrait;

    /**
     * @test
     */
    public function testGetYear()
    {
        $crawler = new Crawler($this->getOfferHtml());
        $scrapper = new AverageYearScrapper();

        $expected = 2015.00;
        $result = $scrapper->getAverageData($crawler);

        $this->assertEquals($expected, $result);
    }
}
