<?php
/**
 * File: FilterArray.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Filter;

use ArrayIterator;
use Iterator;
use IteratorIterator;

/**
 * Class FilterArray
 * @package MSlwk\Otomoto\App\Stats\Filter
 */
class FilterArray extends IteratorIterator implements Iterator
{
    /**
     * FilterArray constructor.
     * @param FilterInterface[]|null[] ...$filters
     */
    public function __construct(?FilterInterface ...$filters)
    {
        parent::__construct(new ArrayIterator($filters));
    }

    /**
     * @return FilterInterface
     */
    public function current(): FilterInterface
    {
        return $this->getInnerIterator()->current();
    }

    /**
     * @param FilterInterface $filter
     */
    public function add(FilterInterface $filter): void
    {
        $this->getInnerIterator()->append($filter);
    }

    /**
     * @param int $key
     * @param FilterInterface $filter
     */
    public function set(int $key, FilterInterface $filter): void
    {
        $this->getInnerIterator()->offsetSet($key, $filter);
    }

    /**
     * @param int $key
     * @return FilterInterface
     */
    public function get(int $key): FilterInterface
    {
        return $this->getInnerIterator()->offsetGet($key);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->getInnerIterator()->count();
    }
}
