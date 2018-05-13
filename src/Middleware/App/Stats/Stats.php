<?php
/**
 * File: Stats.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\App\Stats;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTOInterface;
use MSlwk\Otomoto\App\Stats\Data\StatsDTOInterface;
use MSlwk\Otomoto\App\Stats\Filter\FilterArray;
use MSlwk\Otomoto\App\Stats\StatsProvider;

/**
 * Class Stats
 * @package MSlwk\Otomoto\Middleware\App\Stats
 */
class Stats
{
    /**
     * @var StatsProvider
     */
    private $statsProvider;

    /**
     * Stats constructor.
     * @param StatsProvider $statsProvider
     */
    public function __construct(
        StatsProvider $statsProvider
    ) {
        $this->statsProvider = $statsProvider;
    }

    /**
     * @param ManufacturerDTOInterface $manufacturer
     * @param ModelDTOInterface $model
     * @param FilterArray $filters
     * @return StatsDTOInterface
     */
    public function getStats(
        ManufacturerDTOInterface $manufacturer,
        ModelDTOInterface $model,
        FilterArray $filters
    ): StatsDTOInterface {
        return $this->statsProvider->getStats($manufacturer, $model, $filters);
    }
}
