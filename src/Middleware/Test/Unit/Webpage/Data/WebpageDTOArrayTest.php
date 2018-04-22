<?php
/**
 * File: WebpageDTOArrayTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTOArray;
use PHPUnit\Framework\TestCase;

/**
 * Class WebpageDTOArrayTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Data
 */
class WebpageDTOArrayTest extends TestCase
{
    /**
     * @return array
     */
    public function htmlsDataProvider()
    {
        return [
            [
                'html1',
                'html132'
            ],
            [
                'html15',
                'html11'
            ],
            [
                'html1x',
                'html1566'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider htmlsDataProvider
     * @param $firstHtml
     * @param $secondHtml
     */
    public function testGetHtmlsAddedViaConstructor($firstHtml, $secondHtml)
    {
        $firstHtmlDTO = new WebpageDTO($firstHtml);
        $secondHtmlDTO = new WebpageDTO($secondHtml);

        $webpageDTOArray = new WebpageDTOArray($firstHtmlDTO, $secondHtmlDTO);

        $this->assertEquals($firstHtml, $webpageDTOArray->get(0)->getHtml());
        $this->assertEquals($secondHtml, $webpageDTOArray->get(1)->getHtml());
    }

    /**
     * @test
     * @dataProvider htmlsDataProvider
     * @param $firstHtml
     * @param $secondHtml
     */
    public function testGetHtmlsAddedViaAdd($firstHtml, $secondHtml)
    {
        $firstHtmlDTO = new WebpageDTO($firstHtml);
        $secondHtmlDTO = new WebpageDTO($secondHtml);

        $webpageDTOArray = new WebpageDTOArray();
        $webpageDTOArray->add($firstHtmlDTO);
        $webpageDTOArray->add($secondHtmlDTO);

        $this->assertEquals($firstHtml, $webpageDTOArray->get(0)->getHtml());
        $this->assertEquals($secondHtml, $webpageDTOArray->get(1)->getHtml());
    }

    /**
     * @test
     * @dataProvider htmlsDataProvider
     * @param $firstHtml
     * @param $secondHtml
     */
    public function testGetHtmlsAddedViaSet($firstHtml, $secondHtml)
    {
        $firstHtmlDTO = new WebpageDTO($firstHtml);
        $secondHtmlDTO = new WebpageDTO($secondHtml);

        $webpageDTOArray = new WebpageDTOArray();
        $webpageDTOArray->set(4, $firstHtmlDTO);
        $webpageDTOArray->set(1, $secondHtmlDTO);

        $this->assertEquals($firstHtml, $webpageDTOArray->get(4)->getHtml());
        $this->assertEquals($secondHtml, $webpageDTOArray->get(1)->getHtml());
    }

    /**
     * @test
     * @dataProvider htmlsDataProvider
     * @param $firstHtml
     * @param $secondHtml
     */
    public function testCurrent($firstHtml, $secondHtml)
    {
        $firstHtmlDTO = new WebpageDTO($firstHtml);
        $secondHtmlDTO = new WebpageDTO($secondHtml);

        $webpageDTOArray = new WebpageDTOArray($firstHtmlDTO, $secondHtmlDTO);

        $this->assertEquals($firstHtml, $webpageDTOArray->current()->getHtml());
        $webpageDTOArray->next();
        $this->assertEquals($secondHtml, $webpageDTOArray->current()->getHtml());
    }

    /**
     * @test
     * @dataProvider htmlsDataProvider
     * @param $firstHtml
     * @param $secondHtml
     */
    public function testCount($firstHtml, $secondHtml)
    {
        $firstHtmlDTO = new WebpageDTO($firstHtml);
        $secondHtmlDTO = new WebpageDTO($secondHtml);

        $webpageDTOArray = new WebpageDTOArray($firstHtmlDTO, $secondHtmlDTO);

        $this->assertEquals(2, $webpageDTOArray->count());
    }
}