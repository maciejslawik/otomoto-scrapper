<?php
/**
 * File: ManufacturersScrappedValidatorTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Manufacturer\Validator;

use MSlwk\Otomoto\App\Exception\ManufacturersNotFoundException;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use MSlwk\Otomoto\App\Manufacturer\Validator\ManufacturersScrappedValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class ManufacturersScrappedValidatorTest
 * @package MSlwk\Otomoto\App\Test\Unit\Manufacturer\Validator
 */
class ManufacturersScrappedValidatorTest extends TestCase
{
    /**
     * @var ManufacturersScrappedValidator
     */
    private $validator;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->validator = new ManufacturersScrappedValidator();
    }

    /**
     * @test
     */
    public function testValidationPasses()
    {
        $manufacturerDTO = new ManufacturerDTO('manufacturer');
        $manufacturerDTOArray = new ManufacturerDTOArray($manufacturerDTO);

        $this->assertEmpty($this->validator->validate($manufacturerDTOArray));
    }

    /**
     * @test
     */
    public function testValidationThrowsException()
    {
        $manufacturerDTOArray = new ManufacturerDTOArray();

        $this->expectException(ManufacturersNotFoundException::class);
        $this->validator->validate($manufacturerDTOArray);
    }
}
