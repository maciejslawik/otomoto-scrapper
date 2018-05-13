<?php
declare(strict_types=1);

/**
 * File:FromYearFilterTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Filter;

use MSlwk\Otomoto\App\Exception\IncorrectFilterValueException;
use MSlwk\Otomoto\App\Stats\Filter\FromYearFilter;
use MSlwk\Otomoto\App\Stats\Filter\Validator\FilterValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class FromYearFilterTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Filter
 */
class FromYearFilterTest extends TestCase
{
    /**
     * @var MockObject|FilterValidatorInterface
     */
    private $validator;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->validator = $this->getMockBuilder(FilterValidatorInterface::class)
            ->getMock();
    }

    /**
     * @test
     * @throws IncorrectFilterValueException
     */
    public function testSetGetValue()
    {
        $filter = new FromYearFilter($this->validator, '2015');

        $this->assertEquals('2015', $filter->getValue());
        $filter->setValue('2017');
        $this->assertEquals('2017', $filter->getValue());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $filter = new FromYearFilter($this->validator, '2015');
        $expected = 'search[filter_float_year:from]';
        $this->assertEquals($expected, $filter->getName());
    }

    /**
     * @test
     */
    public function testGetDescription()
    {
        $filter = new FromYearFilter($this->validator, '2015');
        $expected = 'FROM year of production';
        $this->assertEquals($expected, $filter->getDescription());
    }
}
