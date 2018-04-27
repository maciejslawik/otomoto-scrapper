<?php
/**
 * File: ReactPHPAdapterFactoryTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Factory\ReactPHP;

use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ReactPHPRequestAdapter;
use MSlwk\Otomoto\Middleware\Webpage\Factory\ReactPHP\ReactPHPAdapterFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class ReactPHPAdapterFactoryTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Webpage\Factory\ReactPHP
 */
class ReactPHPAdapterFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function testFactoryReturnsCorrectObjectType()
    {
        $adapterFactory = new ReactPHPAdapterFactory();
        $expectedType = ReactPHPRequestAdapter::class;

        $this->assertInstanceOf($expectedType, $adapterFactory->create());
    }
}
