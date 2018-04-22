<?php
/**
 * File: UrlDTOArray.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Data;

use Iterator;
use IteratorIterator;
use ArrayIterator;

/**
 * Class UrlDTOArray
 * @package MSlwk\Otomoto\Middleware\Webpage\Data
 */
class UrlDTOArray extends IteratorIterator implements Iterator
{
    /**
     * UrlDTOArray constructor.
     * @param UrlDTOInterface[]|null[] ...$manufacturerDTOs
     */
    public function __construct(?UrlDTOInterface ...$manufacturerDTOs)
    {
        parent::__construct(new ArrayIterator($manufacturerDTOs));
    }

    /**
     * @return UrlDTOInterface
     */
    public function current(): UrlDTOInterface
    {
        return $this->getInnerIterator()->current();
    }

    /**
     * @param UrlDTOInterface $urlDTO
     */
    public function add(UrlDTOInterface $urlDTO): void
    {
        $this->getInnerIterator()->append($urlDTO);
    }

    /**
     * @param int $key
     * @param UrlDTOInterface $urlDTO
     */
    public function set(int $key, UrlDTOInterface $urlDTO): void
    {
        $this->getInnerIterator()->offsetSet($key, $urlDTO);
    }

    /**
     * @param int $key
     * @return UrlDTOInterface
     */
    public function get(int $key): UrlDTOInterface
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
