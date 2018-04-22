<?php
/**
 * File: ManufacturerHtmlScrapperInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Manufacturer\Scrapper;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;

/**
 * Interface ManufacturerHtmlScrapperInterface
 * @package MSlwk\Otomoto\App\Manufacturer\Scrapper
 */
interface ManufacturerHtmlScrapperInterface
{
    /**
     * @param string $html
     * @return ManufacturerDTOArray
     */
    public function scrapManufacturers(string $html): ManufacturerDTOArray;
}
