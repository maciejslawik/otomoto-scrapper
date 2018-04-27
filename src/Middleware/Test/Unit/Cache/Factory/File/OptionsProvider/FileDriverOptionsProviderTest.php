<?php
/**
 * File: FileDriverOptionsProviderTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\Cache\Factory\File\OptionsProvider;

use MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider\FileDriverOptionsProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class FileDriverOptionsProviderTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\Cache\Factory\File\OptionsProvider
 */
class FileDriverOptionsProviderTest extends TestCase
{
    /**
     * @test
     */
    public function testGetOptionsHasKeyPath()
    {
        $optionsProvider = new FileDriverOptionsProvider();
        $this->assertArrayHasKey('path', $optionsProvider->getOptions());
    }
}
