<?php
/**
 * File: ManufacturerUrlSuffixProviderInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Url;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;

/**
 * Interface ManufacturerUrlSuffixProviderInterface
 * @package MSlwk\Otomoto\App\Model\Url
 */
interface ManufacturerUrlSuffixProviderInterface
{
    /**
     * @param ManufacturerDTOInterface $manufacturerDTO
     * @return mixed
     */
    public function getUrlSuffix(ManufacturerDTOInterface $manufacturerDTO);
}
