<?php
/**
 * File: ClientFactoryTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Adapter\ReactPHP;

use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ClientFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use React\EventLoop\LoopInterface;
use React\HttpClient\Client;

/**
 * Class ClientFactoryTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Adapter\ReactPHP
 */
class ClientFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function testFactoryReturnsCorrectObject()
    {
        /** @var MockObject|LoopInterface $loop */
        $loop = $this->getMockBuilder(LoopInterface::class)
            ->getMock();

        $expectedType = Client::class;

        $factory = new ClientFactory();
        $this->assertInstanceOf($expectedType, $factory->create($loop));
    }
}
