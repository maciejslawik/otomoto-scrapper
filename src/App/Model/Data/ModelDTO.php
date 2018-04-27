<?php
/**
 * File: ModelDTO.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Data;

/**
 * Class ModelDTO
 * @package MSlwk\Otomoto\App\Model\Data
 */
class ModelDTO implements ModelDTOInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * ModelDTO constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
