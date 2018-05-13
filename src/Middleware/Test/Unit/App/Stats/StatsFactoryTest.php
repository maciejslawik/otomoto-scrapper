<?php
declare(strict_types=1);

/**
 * File:StatsFactoryTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\Middleware\Test\Unit\App\Stats;

use MSlwk\Otomoto\Middleware\App\Stats\Stats;
use MSlwk\Otomoto\Middleware\App\Stats\StatsFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class StatsFactoryTest
 * @package MSlwk\Otomoto\Middleware\Test\Unit\App\Stats
 */
class StatsFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function testCreateStatsObject()
    {
        $statsFactory = new StatsFactory();
        $statsObject = $statsFactory->create();

        $expectedType = Stats::class;

        $this->assertInstanceOf($expectedType, $statsObject);
    }
}
