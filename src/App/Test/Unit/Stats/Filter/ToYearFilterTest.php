<?php
declare(strict_types=1);

/**
 * File:ToYearFilterTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Filter;

use MSlwk\Otomoto\App\Exception\IncorrectFilterValueException;
use MSlwk\Otomoto\App\Stats\Filter\FromYearFilter;
use MSlwk\Otomoto\App\Stats\Filter\ToYearFilter;
use MSlwk\Otomoto\App\Stats\Filter\Validator\FilterValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ToYearFilterTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Filter
 */
class ToYearFilterTest extends TestCase
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
        $this->validator->expects($this->exactly(2))
            ->method('validate')
            ->withConsecutive(['2015'], ['2017']);

        $filter = new ToYearFilter($this->validator, '2015');

        $this->assertEquals('2015', $filter->getValue());
        $filter->setValue('2017');
        $this->assertEquals('2017', $filter->getValue());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $filter = new ToYearFilter($this->validator, '2015');
        $expected = 'search[filter_float_year:to]';
        $this->assertEquals($expected, $filter->getName());
    }

    /**
     * @test
     */
    public function testGetDescription()
    {
        $filter = new ToYearFilter($this->validator, '2015');
        $expected = 'TO year of production';
        $this->assertEquals($expected, $filter->getDescription());
    }
}
