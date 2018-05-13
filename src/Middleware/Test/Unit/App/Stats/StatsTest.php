<?php
declare(strict_types=1);

/**
 * File:StatsTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\App\Stats;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTOInterface;
use MSlwk\Otomoto\App\Stats\Data\StatsDTOInterface;
use MSlwk\Otomoto\App\Stats\Filter\FilterArray;
use MSlwk\Otomoto\App\Stats\StatsProvider;
use MSlwk\Otomoto\Middleware\App\Stats\Stats;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class StatsTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\App\Stats
 */
class StatsTest extends TestCase
{
    /**
     * @var MockObject|StatsProvider
     */
    private $statsProvider;

    /**
     * @var MockObject|ManufacturerDTOInterface
     */
    private $manufacturer;

    /**
     * @var MockObject|ModelDTOInterface
     */
    private $model;

    /**
     * @var MockObject|FilterArray
     */
    private $filters;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->statsProvider = $this->getMockBuilder(StatsProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manufacturer = $this->getMockBuilder(ManufacturerDTOInterface::class)
            ->getMock();
        $this->model = $this->getMockBuilder(ModelDTOInterface::class)
            ->getMock();
        $this->filters = $this->getMockBuilder(FilterArray::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @test
     */
    public function testGetStats()
    {
        $statsMiddleware = new Stats($this->statsProvider);

        $stats = $this->getMockBuilder(StatsDTOInterface::class)
            ->getMock();

        $this->statsProvider->expects($this->once())
            ->method('getStats')
            ->with(
                $this->manufacturer,
                $this->model,
                $this->filters
            )
            ->will($this->returnValue($stats));

        $result = $statsMiddleware->getStats(
            $this->manufacturer,
            $this->model,
            $this->filters
        );
        $this->assertEquals($stats, $result);
    }
}
