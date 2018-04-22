<?php
/**
 * File: UrlDTOTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Data;

use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTO;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlDTOTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Data
 */
class UrlDTOTest extends TestCase
{
    /**
     * @return array
     */
    public function urlDataProvider()
    {
        return [
            [
                'http://url1.com'
            ],
            [
                'http://url2.com'
            ],
            [
                'http://url3.com'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider urlDataProvider
     * @param $url
     */
    public function testGetName($url)
    {
        $urlDTO = new UrlDTO($url);
        $this->assertEquals($url, $urlDTO->getUrl());
    }
}
