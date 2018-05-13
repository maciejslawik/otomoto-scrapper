<?php
/**
 * File: YearFilterValidator.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Filter\Validator;

use MSlwk\Otomoto\App\Exception\IncorrectFilterValueException;

/**
 * Class YearFilterValidator
 * @package MSlwk\Otomoto\App\Stats\Filter\Validator
 */
class YearFilterValidator implements FilterValidatorInterface
{
    /**
     * @param string $value
     * @return void
     * @throws IncorrectFilterValueException
     */
    public function validate(string $value): void
    {
        $year = (int)$value;
        if ($year < 1900 || $year > 2050) {
            throw new IncorrectFilterValueException("Value {$value} for filter is incorrect");
        }
    }
}
