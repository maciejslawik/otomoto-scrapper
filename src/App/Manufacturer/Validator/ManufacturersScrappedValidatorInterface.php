<?php
/**
 * File: ManufacturersScrappedValidatorInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Manufacturer\Validator;

use MSlwk\Otomoto\App\Exception\ManufacturersNotFoundException;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;

/**
 * Interface ManufacturersScrappedValidatorInterface
 * @package MSlwk\Otomoto\App\Manufacturer\Validator
 */
interface ManufacturersScrappedValidatorInterface
{
    /**
     * @param ManufacturerDTOArray $manufacturerDTOArray
     * @return void
     * @throws ManufacturersNotFoundException
     */
    public function validate(ManufacturerDTOArray $manufacturerDTOArray): void;
}
