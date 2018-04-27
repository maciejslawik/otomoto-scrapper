<?php
/**
 * File: ManufacturerDTOInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Manufacturer\Data;

/**
 * Interface ManufacturerDTOInterface
 * @package MSlwk\Otomoto\App\Manufacturer\Data
 */
interface ManufacturerDTOInterface
{
    /**
     * @return string
     */
    public function getName(): string;
}
