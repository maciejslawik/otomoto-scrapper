<?php
/**
 * File: ModelsScrappedValidatorInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Validator;

use MSlwk\Otomoto\App\Exception\ModelsNotFoundException;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;

/**
 * Interface ModelsScrappedValidatorInterface
 * @package MSlwk\Otomoto\App\Model\Validator
 */
interface ModelsScrappedValidatorInterface
{
    /**
     * @param ModelDTOArray $modelDTOArray
     * @throws ModelsNotFoundException
     */
    public function validate(ModelDTOArray $modelDTOArray): void;
}
