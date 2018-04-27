<?php
/**
 * File: ManufacturerUrlSuffixProviderTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Model\Url;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Model\Url\ManufacturerUrlSuffixProvider;
use MSlwk\Otomoto\App\Slugify\SlugifierInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ManufacturerUrlSuffixProviderTest
 * @package MSlwk\Otomoto\App\Test\Unit\Model\Url
 */
class ManufacturerUrlSuffixProviderTest extends TestCase
{
    /**
     * @test
     */
    public function testProviderReturnsCorrectUrlSuffix()
    {
        /** @var MockObject|SlugifierInterface $slugifier */
        $slugifier = $this->getMockBuilder(SlugifierInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $suffixProvider = new ManufacturerUrlSuffixProvider($slugifier);

        $manufacturerDTO = new ManufacturerDTO('Alfa Romeo');
        $slugifier->expects($this->once())
            ->method('slugify')
            ->with($manufacturerDTO->getName())
            ->will($this->returnValue('alfa-romeo'));

        $expectedSuffix = '/osobowe/alfa-romeo/';

        $this->assertEquals($expectedSuffix, $suffixProvider->getUrlSuffix($manufacturerDTO));
    }
}
