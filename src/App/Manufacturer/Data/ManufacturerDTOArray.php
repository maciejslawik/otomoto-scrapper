<?php
/**
 * File: ManufacturerDTOArray.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Manufacturer\Data;

use ArrayIterator;
use Iterator;
use IteratorIterator;

/**
 * Class ManufacturerDTOArray
 * @package MSlwk\Otomoto\App\Manufacturer\Data
 */
class ManufacturerDTOArray extends IteratorIterator implements Iterator
{
    /**
     * ManufacturerDTOArray constructor.
     * @param ManufacturerDTOInterface[]|null[] ...$manufacturerDTOs
     */
    public function __construct(?ManufacturerDTOInterface ...$manufacturerDTOs)
    {
        parent::__construct(new ArrayIterator($manufacturerDTOs));
    }

    /**
     * @return ManufacturerDTOInterface
     */
    public function current(): ManufacturerDTOInterface
    {
        return $this->getInnerIterator()->current();
    }

    /**
     * @param ManufacturerDTOInterface $manufacturerDTO
     */
    public function add(ManufacturerDTOInterface $manufacturerDTO): void
    {
        $this->getInnerIterator()->append($manufacturerDTO);
    }

    /**
     * @param int $key
     * @param ManufacturerDTOInterface $manufacturerDTO
     */
    public function set(int $key, ManufacturerDTOInterface $manufacturerDTO): void
    {
        $this->getInnerIterator()->offsetSet($key, $manufacturerDTO);
    }

    /**
     * @param int $key
     * @return ManufacturerDTOInterface
     */
    public function get(int $key): ManufacturerDTOInterface
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
