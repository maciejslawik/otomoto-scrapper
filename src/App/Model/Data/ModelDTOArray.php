<?php
/**
 * File: ModelDTOArray.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Data;

use ArrayIterator;
use Iterator;
use IteratorIterator;

/**
 * Class ModelDTOArray
 * @package MSlwk\Otomoto\App\Model\Data
 */
class ModelDTOArray extends IteratorIterator implements Iterator
{
    /**
     * ModelDTOArray constructor.
     * @param ModelDTOInterface[]|null[] ...$modelDTOs
     */
    public function __construct(?ModelDTOInterface ...$modelDTOs)
    {
        parent::__construct(new ArrayIterator($modelDTOs));
    }

    /**
     * @return ModelDTOInterface
     */
    public function current(): ModelDTOInterface
    {
        return $this->getInnerIterator()->current();
    }

    /**
     * @param ModelDTOInterface $modelDTO
     */
    public function add(ModelDTOInterface $modelDTO): void
    {
        $this->getInnerIterator()->append($modelDTO);
    }

    /**
     * @param int $key
     * @param ModelDTOInterface $modelDTO
     */
    public function set(int $key, ModelDTOInterface $modelDTO): void
    {
        $this->getInnerIterator()->offsetSet($key, $modelDTO);
    }

    /**
     * @param int $key
     * @return ModelDTOInterface
     */
    public function get(int $key): ModelDTOInterface
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
