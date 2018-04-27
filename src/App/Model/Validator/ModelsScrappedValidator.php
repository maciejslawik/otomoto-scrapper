<?php
/**
 * File: ModelsScrappedValidator.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Validator;

use MSlwk\Otomoto\App\Exception\ModelsNotFoundException;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;

/**
 * Class ModelsScrappedValidator
 * @package MSlwk\Otomoto\App\Model\Validator
 */
class ModelsScrappedValidator implements ModelsScrappedValidatorInterface
{
    /**
     * @param ModelDTOArray $modelDTOArray
     * @throws ModelsNotFoundException
     */
    public function validate(ModelDTOArray $modelDTOArray): void
    {
        if ($modelDTOArray->count() < 1) {
            throw new ModelsNotFoundException('No models were found');
        }
    }
}
