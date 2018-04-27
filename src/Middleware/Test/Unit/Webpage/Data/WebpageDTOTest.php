<?php
/**
 * File: WebpageDTOTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Data;

use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTO;
use PHPUnit\Framework\TestCase;

/**
 * Class WebpageDTOTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Data
 */
class WebpageDTOTest extends TestCase
{
    /**
     * @return array
     */
    public function htmlDataProvider()
    {
        return [
            [
                'html1'
            ],
            [
                'html2'
            ],
            [
                'html3'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider htmlDataProvider
     * @param $html
     */
    public function testGetName($html)
    {
        $webpageDTO = new WebpageDTO($html);
        $this->assertEquals($html, $webpageDTO->getHtml());
    }
}
