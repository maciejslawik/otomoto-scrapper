<?php
/**
 * File: ManufacturerDTO.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Manufacturer\Data;

/**
 * Class ManufacturerDTO
 * @package MSlwk\Otomoto\App\Manufacturer\Data
 */
class ManufacturerDTO implements ManufacturerDTOInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * ManufacturerDTO constructor.
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
