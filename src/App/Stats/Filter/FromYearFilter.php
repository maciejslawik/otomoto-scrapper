<?php
/**
 * File: FromYearFilter.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Filter;

use MSlwk\Otomoto\App\Exception\IncorrectFilterValueException;
use MSlwk\Otomoto\App\Stats\Filter\Validator\FilterValidatorInterface;

/**
 * Class FromYearFilter
 * @package MSlwk\Otomoto\App\Stats\Filter
 */
class FromYearFilter implements FilterInterface
{
    const FILTER_NAME = 'search[filter_float_year:from]';
    const FILTER_DESC = 'FROM year of production';

    /**
     * @var string
     */
    private $value;

    /**
     * @var FilterValidatorInterface
     */
    private $validator;

    /**
     * FromYearFilter constructor.
     * @param FilterValidatorInterface $validator
     * @param string $value
     * @throws IncorrectFilterValueException
     */
    public function __construct(FilterValidatorInterface $validator, string $value)
    {
        $this->validator = $validator;
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::FILTER_NAME;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return self::FILTER_DESC;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return void
     * @throws IncorrectFilterValueException
     */
    public function setValue(string $value): void
    {
        $this->validator->validate($value);
        $this->value = $value;
    }
}
