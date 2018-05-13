<?php
/**
 * File: ReactPHPRequestAdapterTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Integration\Webpage\Adapter\ReactPHP;

use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ClientFactory;
use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ReactPHPRequestAdapter;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Exception\GETHandlerException;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;

/**
 * Class ReactPHPRequestAdapterTest
 * @package MSlwk\Otomoto\Middleware\Test\Integration\Webpage\Adapter\ReactPHP
 */
class ReactPHPRequestAdapterTest extends TestCase
{
    /**
     * @var ReactPHPRequestAdapter
     */
    private $requestAdapter;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->requestAdapter = new ReactPHPRequestAdapter(Factory::create(), new ClientFactory());
    }

    /**
     * @test
     */
    public function testGetMultipleWebpages()
    {
        $url1 = new UrlDTO('https://www.google.com/');
        $url2 = new UrlDTO('https://www.bing.com/');
        $urls = new UrlDTOArray($url1, $url2);

        $webpages = $this->requestAdapter->getWebpages($urls);

        $expectedType = WebpageDTOArray::class;
        $expectedCount = 2;

        $this->assertInstanceOf($expectedType, $webpages);
        $this->assertEquals($expectedCount, $webpages->count());
        $this->assertContains('<html', $webpages->get(0)->getHtml());
        $this->assertContains('<html', $webpages->get(1)->getHtml());
    }

    /**
     * @test
     */
    public function testGetSingleWebpage()
    {
        $url1 = new UrlDTO('https://www.google.com/');
        $urls = new UrlDTOArray($url1);

        $webpages = $this->requestAdapter->getWebpages($urls);

        $expectedType = WebpageDTOArray::class;
        $expectedCount = 1;

        $this->assertInstanceOf($expectedType, $webpages);
        $this->assertEquals($expectedCount, $webpages->count());
        $this->assertContains('<html', $webpages->get(0)->getHtml());
    }

    /**
     * @test
     */
    public function testIncorrectUrlGivenAndExceptionThrown()
    {
        $url1 = new UrlDTO('wrong url');
        $urls = new UrlDTOArray($url1);

        $this->expectException(GETHandlerException::class);
        $this->requestAdapter->getWebpages($urls);
    }
}
