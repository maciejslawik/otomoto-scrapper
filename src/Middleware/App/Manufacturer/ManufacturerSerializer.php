<?php
/**
 * File: ManufacturerSerializer.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\App\Manufacturer;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;

/**
 * Class ManufacturerSerializer
 * @package MSlwk\Otomoto\Middleware\App\Manufacturer
 */
class ManufacturerSerializer
{
    /**
     * @param ManufacturerDTOArray $manufacturerDTOArray
     * @return string
     */
    public function serialize(ManufacturerDTOArray $manufacturerDTOArray): string
    {
        $manufacturerArray = [];
        foreach ($manufacturerDTOArray as $manufacturerDTO) {
            $manufacturerArray[] = [
                'name' => $manufacturerDTO->getName()
            ];
        }
        return serialize($manufacturerArray);
    }

    /**
     * @param string $manufacturersDTOArrayString
     * @return ManufacturerDTOArray
     */
    public function unserialize(string $manufacturersDTOArrayString): ManufacturerDTOArray
    {
        $manufacturerArray = unserialize($manufacturersDTOArrayString);
        $manufacturerDTOArray = new ManufacturerDTOArray();

        foreach ($manufacturerArray as $manufacturerData) {
            $manufacturerDTO = new ManufacturerDTO($manufacturerData['name']);
            $manufacturerDTOArray->add($manufacturerDTO);
        }

        return $manufacturerDTOArray;
    }
}
