<?php
/**
 * File: ModelUrlSuffixProviderTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Model\Url;

use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use MSlwk\Otomoto\App\Model\Url\ModelUrlSuffixProvider;
use MSlwk\Otomoto\App\Slugify\SlugifierInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ModelUrlSuffixProviderTest
 * @package MSlwk\Otomoto\App\Test\Unit\Model\Url
 */
class ModelUrlSuffixProviderTest extends TestCase
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

        $suffixProvider = new ModelUrlSuffixProvider($slugifier);

        $manufacturerDTO = new ModelDTO('Seria 3');
        $slugifier->expects($this->once())
            ->method('slugify')
            ->with($manufacturerDTO->getName())
            ->will($this->returnValue('seria-3'));

        $expectedSuffix = 'seria-3/';

        $this->assertEquals($expectedSuffix, $suffixProvider->getUrlSuffix($manufacturerDTO));
    }
}
