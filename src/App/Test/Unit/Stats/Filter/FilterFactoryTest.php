<?php
declare(strict_types=1);

/**
 * File:FilterFactoryTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Filter;

use MSlwk\Otomoto\App\Exception\NoSuchFilterException;
use MSlwk\Otomoto\App\Stats\Filter\FilterFactory;
use MSlwk\Otomoto\App\Stats\Filter\FromYearFilter;
use MSlwk\Otomoto\App\Stats\Filter\ToYearFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class FilterFactoryTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Filter
 */
class FilterFactoryTest extends TestCase
{
    /**
     * @test
     * @throws NoSuchFilterException
     */
    public function testCreateFromYearFilter()
    {
        $filterFactory = new FilterFactory();
        $expectedType = FromYearFilter::class;
        $result = $filterFactory->create('from', '2016');

        $this->assertInstanceOf($expectedType, $result);
    }

    /**
     * @test
     * @throws NoSuchFilterException
     */
    public function testCreateFromToFilter()
    {
        $filterFactory = new FilterFactory();
        $expectedType = ToYearFilter::class;
        $result = $filterFactory->create('to', '2016');

        $this->assertInstanceOf($expectedType, $result);
    }

    /**
     * @test
     * @throws NoSuchFilterException
     */
    public function testCreateNotExistingFilterThrowsException()
    {
        $filterFactory = new FilterFactory();

        $this->expectException(NoSuchFilterException::class);
        $filterFactory->create('not', 'existing');
    }
}
