<?php
declare(strict_types=1);

/**
 * File:FilterArrayTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Filter;

use MSlwk\Otomoto\App\Stats\Filter\FilterArray;
use MSlwk\Otomoto\App\Stats\Filter\FilterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class FilterArrayTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Filter
 */
class FilterArrayTest extends TestCase
{
    /**
     * @test
     */
    public function testGetFiltersAddedViaConstructor()
    {
        /** @var MockObject|FilterInterface $firstFilter */
        $firstFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();
        $firstFilter->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('from'));
        /** @var MockObject|FilterInterface $secondFilter */
        $secondFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();
        $secondFilter->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('to'));

        $filterArray = new FilterArray($firstFilter, $secondFilter);

        $this->assertEquals('from', $filterArray->get(0)->getName());
        $this->assertEquals('to', $filterArray->get(1)->getName());
    }

    /**
     * @test
     */
    public function testGetFiltersAddedViaAdd()
    {
        /** @var MockObject|FilterInterface $firstFilter */
        $firstFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();
        $firstFilter->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('from'));
        /** @var MockObject|FilterInterface $secondFilter */
        $secondFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();
        $secondFilter->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('to'));

        $filterArray = new FilterArray();

        $filterArray->add($firstFilter);
        $filterArray->add($secondFilter);

        $this->assertEquals('from', $filterArray->get(0)->getName());
        $this->assertEquals('to', $filterArray->get(1)->getName());
    }

    /**
     * @test
     */
    public function testGetFiltersAddedViaSet()
    {
        /** @var MockObject|FilterInterface $firstFilter */
        $firstFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();
        $firstFilter->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('from'));
        /** @var MockObject|FilterInterface $secondFilter */
        $secondFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();
        $secondFilter->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('to'));

        $filterArray = new FilterArray();

        $filterArray->set(2, $firstFilter);
        $filterArray->set(1, $secondFilter);

        $this->assertEquals('from', $filterArray->get(2)->getName());
        $this->assertEquals('to', $filterArray->get(1)->getName());
    }

    /**
     * @test
     */
    public function testCurrent()
    {
        /** @var MockObject|FilterInterface $firstFilter */
        $firstFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();
        $firstFilter->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('from'));
        /** @var MockObject|FilterInterface $secondFilter */
        $secondFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();
        $secondFilter->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('to'));

        $filterArray = new FilterArray($firstFilter, $secondFilter);

        $this->assertEquals('from', $filterArray->current()->getName());
        $filterArray->next();
        $this->assertEquals('to', $filterArray->current()->getName());
    }

    /**
     * @test
     */
    public function testCount()
    {
        /** @var MockObject|FilterInterface $firstFilter */
        $firstFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();
        /** @var MockObject|FilterInterface $secondFilter */
        $secondFilter = $this->getMockBuilder(FilterInterface::class)
            ->getMock();

        $filterArray = new FilterArray($firstFilter, $secondFilter);

        $this->assertEquals(2, $filterArray->count());
    }
}
