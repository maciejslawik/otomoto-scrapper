<?php
/**
 * File: UrlDTOArrayTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Data;

use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTOArray;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlDTOArrayTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Data
 */
class UrlDTOArrayTest extends TestCase
{
    /**
     * @return array
     */
    public function urlsDataProvider()
    {
        return [
            [
                'http://url1.com',
                'http://url4.com'
            ],
            [
                'http://url11.com',
                'http://url153.com'
            ],
            [
                'http://url11.com',
                'http://url421.com'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider urlsDataProvider
     * @param $firstUrl
     * @param $secondUrl
     */
    public function testGetUrlsAddedViaConstructor($firstUrl, $secondUrl)
    {
        $firstUrlDTO = new UrlDTO($firstUrl);
        $secondUrlDTO = new UrlDTO($secondUrl);

        $urlDTOArray = new UrlDTOArray($firstUrlDTO, $secondUrlDTO);

        $this->assertEquals($firstUrl, $urlDTOArray->get(0)->getUrl());
        $this->assertEquals($secondUrl, $urlDTOArray->get(1)->getUrl());
    }

    /**
     * @test
     * @dataProvider urlsDataProvider
     * @param $firstUrl
     * @param $secondUrl
     */
    public function testGetUrlsAddedViaAdd($firstUrl, $secondUrl)
    {
        $firstUrlDTO = new UrlDTO($firstUrl);
        $secondUrlDTO = new UrlDTO($secondUrl);

        $urlDTOArray = new UrlDTOArray();
        $urlDTOArray->add($firstUrlDTO);
        $urlDTOArray->add($secondUrlDTO);

        $this->assertEquals($firstUrl, $urlDTOArray->get(0)->getUrl());
        $this->assertEquals($secondUrl, $urlDTOArray->get(1)->getUrl());
    }

    /**
     * @test
     * @dataProvider urlsDataProvider
     * @param $firstUrl
     * @param $secondUrl
     */
    public function testGetUrlsAddedViaSet($firstUrl, $secondUrl)
    {
        $firstUrlDTO = new UrlDTO($firstUrl);
        $secondUrlDTO = new UrlDTO($secondUrl);

        $urlDTOArray = new UrlDTOArray();
        $urlDTOArray->set(4, $firstUrlDTO);
        $urlDTOArray->set(1, $secondUrlDTO);

        $this->assertEquals($firstUrl, $urlDTOArray->get(4)->getUrl());
        $this->assertEquals($secondUrl, $urlDTOArray->get(1)->getUrl());
    }

    /**
     * @test
     * @dataProvider urlsDataProvider
     * @param $firstUrl
     * @param $secondUrl
     */
    public function testCurrent($firstUrl, $secondUrl)
    {
        $firstUrlDTO = new UrlDTO($firstUrl);
        $secondUrlDTO = new UrlDTO($secondUrl);

        $urlDTOArray = new UrlDTOArray($firstUrlDTO, $secondUrlDTO);

        $this->assertEquals($firstUrl, $urlDTOArray->current()->getUrl());
        $urlDTOArray->next();
        $this->assertEquals($secondUrl, $urlDTOArray->current()->getUrl());
    }

    /**
     * @test
     * @dataProvider urlsDataProvider
     * @param $firstUrl
     * @param $secondUrl
     */
    public function testCount($firstUrl, $secondUrl)
    {
        $firstUrlDTO = new UrlDTO($firstUrl);
        $secondUrlDTO = new UrlDTO($secondUrl);

        $urlDTOArray = new UrlDTOArray($firstUrlDTO, $secondUrlDTO);

        $this->assertEquals(2, $urlDTOArray->count());
    }
}
