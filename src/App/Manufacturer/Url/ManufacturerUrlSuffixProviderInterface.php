<?php
/**
 * File: ManufacturerUrlSuffixProviderInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Manufacturer\Url;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;

/**
 * Interface ManufacturerUrlSuffixProviderInterface
 * @package MSlwk\Otomoto\App\Manufacturer\Url
 */
interface ManufacturerUrlSuffixProviderInterface
{
    /**
     * @param ManufacturerDTOInterface $manufacturerDTO
     * @return string
     */
    public function getUrlSuffix(ManufacturerDTOInterface $manufacturerDTO): string;
}
