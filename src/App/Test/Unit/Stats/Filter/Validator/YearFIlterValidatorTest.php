<?php
declare(strict_types=1);

/**
 * File:YearFIlterValidatorTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Filter\Validator;

use MSlwk\Otomoto\App\Exception\IncorrectFilterValueException;
use MSlwk\Otomoto\App\Stats\Filter\Validator\YearFilterValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class YearFIlterValidatorTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Filter\Validator
 */
class YearFIlterValidatorTest extends TestCase
{
    /**
     * @var YearFilterValidator
     */
    private $validator;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->validator = new YearFilterValidator();
    }

    /**
     * @test
     * @throws IncorrectFilterValueException
     */
    public function testYearTooLowThrowsException()
    {
        $this->expectException(IncorrectFilterValueException::class);
        $this->validator->validate('1899');
    }

    /**
     * @test
     * @throws IncorrectFilterValueException
     */
    public function testYearTooHighThrowsException()
    {
        $this->expectException(IncorrectFilterValueException::class);
        $this->validator->validate('2100');
    }

    /**
     * @test
     * @throws IncorrectFilterValueException
     */
    public function testCorrectValuePassed()
    {
        $this->assertEquals(null, $this->validator->validate('2016'));
    }
}
