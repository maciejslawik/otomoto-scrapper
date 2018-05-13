<?php
declare(strict_types=1);

/**
 * File:StatsDTOTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Data;

use MSlwk\Otomoto\App\Stats\Data\StatsDTO;
use PHPUnit\Framework\TestCase;

/**
 * Class StatsDTOTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Data
 */
class StatsDTOTest extends TestCase
{
    /**
     * @var StatsDTO
     */
    private $statsDTO;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->statsDTO = new StatsDTO();
    }

    /**
     * @test
     */
    public function testMileage()
    {
        $this->statsDTO->setAverageMileage(3425.32);
        $expectedMileage = 3425.32;

        $this->assertEquals($expectedMileage, $this->statsDTO->getAverageMileage());
    }

    /**
     * @test
     */
    public function testPrice()
    {
        $this->statsDTO->setAveragePrice(65489.21);
        $expectedPrice = 65489.21;

        $this->assertEquals($expectedPrice, $this->statsDTO->getAveragePrice());
    }

    /**
     * @test
     */
    public function testYear()
    {
        $this->statsDTO->setAverageYear(2013.23);
        $expectedYear = 2013.23;

        $this->assertEquals($expectedYear, $this->statsDTO->getAverageYear());
    }
}
