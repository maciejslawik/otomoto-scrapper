<?php
/**
 * File: ModelsScrappedValidatorTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Model\Validator;

use MSlwk\Otomoto\App\Exception\ModelsNotFoundException;
use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use MSlwk\Otomoto\App\Model\Validator\ModelsScrappedValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class ModelsScrappedValidatorTest
 * @package MSlwk\Otomoto\App\Test\Unit\Model\Validator
 */
class ModelsScrappedValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function testValidatorDoesntThrowExceptionWhenArrayIsValid()
    {
        $modelDTOArray = new ModelDTOArray(
            new ModelDTO('Alfa Romeo')
        );

        $validator = new ModelsScrappedValidator();

        $this->assertEquals(null, $validator->validate($modelDTOArray));
    }

    public function testValidatorThrowsExceptionWhenArrayIsEmpty()
    {
        $modelDTOArray = new ModelDTOArray();

        $validator = new ModelsScrappedValidator();

        $this->expectException(ModelsNotFoundException::class);
        $validator->validate($modelDTOArray);
    }

}
