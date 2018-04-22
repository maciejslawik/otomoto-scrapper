<?php
/**
 * File: WebpageDTOArray.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Data;

use Iterator;
use IteratorIterator;
use ArrayIterator;

/**
 * Class WebpageDTOArray
 * @package MSlwk\Otomoto\Middleware\Webpage\Data
 */
class WebpageDTOArray extends IteratorIterator implements Iterator
{
    /**
     * UrlDTOArray constructor.
     * @param WebpageDTOInterface[]|null[] ...$webpageDTOs
     */
    public function __construct(?WebpageDTOInterface ...$webpageDTOs)
    {
        parent::__construct(new ArrayIterator($webpageDTOs));
    }

    /**
     * @return WebpageDTOInterface
     */
    public function current(): WebpageDTOInterface
    {
        return $this->getInnerIterator()->current();
    }

    /**
     * @param WebpageDTOInterface $webpageDTO
     */
    public function add(WebpageDTOInterface $webpageDTO): void
    {
        $this->getInnerIterator()->append($webpageDTO);
    }

    /**
     * @param int $key
     * @param WebpageDTOInterface $webpageDTO
     */
    public function set(int $key, WebpageDTOInterface $webpageDTO): void
    {
        $this->getInnerIterator()->offsetSet($key, $webpageDTO);
    }

    /**
     * @param int $key
     * @return WebpageDTOInterface
     */
    public function get(int $key): WebpageDTOInterface
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
