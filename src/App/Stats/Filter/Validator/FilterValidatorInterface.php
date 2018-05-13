<?php
/**
 * File: FilterValidatorInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Filter\Validator;

use MSlwk\Otomoto\App\Exception\IncorrectFilterValueException;

/**
 * Interface FilterValidatorInterface
 * @package MSlwk\Otomoto\App\Stats\Filter\Validator
 */
interface FilterValidatorInterface
{
    /**
     * @param string $value
     * @return void
     * @throws IncorrectFilterValueException
     */
    public function validate(string $value): void;
}
