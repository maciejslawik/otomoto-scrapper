<?php
/**
 * File: ReactPHPRequestAdapterTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Adapter\ReactPHP;

use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ClientFactory;
use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ReactPHPRequestAdapter;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Exception\GETHandlerException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use React\EventLoop\LoopInterface;
use React\HttpClient\Client;
use React\HttpClient\Request;


/**
 * Class ReactPHPRequestAdapterTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Adapter\ReactPHP
 */
class ReactPHPRequestAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function testCorrectExceptionThrownOnEmptyResult()
    {
        /** @var MockObject|LoopInterface $loop */
        $loop = $this->getMockBuilder(LoopInterface::class)
            ->getMock();
        /** @var MockObject|ClientFactory $clientFactory */
        $clientFactory = $this->getMockBuilder(ClientFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();
        $clientFactory->expects($this->any())
            ->method('create')
            ->will($this->returnValue($client));
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['end'])
            ->getMock();
        $client->expects($this->once())
            ->method('request')
            ->will($this->returnValue($request));

        $urlDTO = new UrlDTO('');
        $urlDTOArray = new UrlDTOArray($urlDTO);
        $adapter = new ReactPHPRequestAdapter($loop, $clientFactory);
        $this->expectException(GETHandlerException::class);
        $adapter->getWebpages($urlDTOArray);
    }
}
