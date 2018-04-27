<?php
/**
 * File: ModelHtmlScrapperInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Scrapper;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;

/**
 * Interface ModelHtmlScrapperInterface
 * @package MSlwk\Otomoto\App\Model\Scrapper
 */
interface ModelHtmlScrapperInterface
{
    /**
     * @param string $html
     * @return ModelDTOArray
     */
    public function scrapModels(string $html): ModelDTOArray;
}
