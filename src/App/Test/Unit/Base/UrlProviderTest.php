<?php
/**
 * File: UrlProviderTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Base;

use MSlwk\Otomoto\App\Base\UrlProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlProviderTest
 * @package MSlwk\Otomoto\App\Test\Unit\Base
 */
class UrlProviderTest extends TestCase
{
    /**
     * @test
     */
    public function testUrlProviderReturnsCorrectUrl()
    {
        $urlProvider = new UrlProvider();
        $expectedUrl = 'https://www.otomoto.pl';

        $this->assertEquals($expectedUrl, $urlProvider->getBaseUrl());
    }
}
