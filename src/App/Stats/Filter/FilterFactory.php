<?php
/**
 * File: FilterFactory.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Filter;

use MSlwk\Otomoto\App\Exception\NoSuchFilterException;
use MSlwk\Otomoto\App\Stats\Filter\Validator\YearFilterValidator;

/**
 * Class FilterFactory
 * @package MSlwk\Otomoto\App\Stats\Filter
 */
class FilterFactory
{
    /**
     * @param string $filterName
     * @param string $value
     * @return FilterInterface
     * @throws NoSuchFilterException
     */
    public function create(string $filterName, string $value): FilterInterface
    {
        switch ($filterName) {
            case 'from':
                return new FromYearFilter(new YearFilterValidator(), $value);
            case 'to':
                return new ToYearFilter(new YearFilterValidator(), $value);
            default:
                throw new NoSuchFilterException('Chosen filter implementation doesn\'t exist');

        }
    }
}
