<?php
/**
 * File: ManufacturersScrappedValidator.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Manufacturer\Validator;

use MSlwk\Otomoto\App\Exception\ManufacturersNotFoundException;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;

/**
 * Class ManufacturersScrappedValidator
 * @package MSlwk\Otomoto\App\Manufacturer\Validator
 */
class ManufacturersScrappedValidator implements ManufacturersScrappedValidatorInterface
{
    /**
     * @param ManufacturerDTOArray $manufacturerDTOArray
     * @return void
     * @throws ManufacturersNotFoundException
     */
    public function validate(ManufacturerDTOArray $manufacturerDTOArray): void
    {
        if ($manufacturerDTOArray->count() < 1) {
            throw new ManufacturersNotFoundException('No manufacturers were found');
        }
    }
}
