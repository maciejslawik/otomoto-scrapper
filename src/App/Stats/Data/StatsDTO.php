<?php
/**
 * File: StatsDTO.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Data;

/**
 * Class StatsDTO
 * @package MSlwk\Otomoto\App\Stats\Data
 */
class StatsDTO implements StatsDTOInterface
{
    /**
     * @var float
     */
    private $averagePrice = 0.0;

    /**
     * @var float
     */
    private $averageMileage = 0.0;

    /**
     * @var float
     */
    private $averageYear = 0.0;

    /**
     * @return float
     */
    public function getAveragePrice(): float
    {
        return $this->averagePrice;
    }

    /**
     * @param float $price
     * @return void
     */
    public function setAveragePrice(float $price): void
    {
        $this->averagePrice = $price;
    }

    /**
     * @return float
     */
    public function getAverageMileage(): float
    {
        return $this->averageMileage;
    }

    /**
     * @param float $mileage
     * @return void
     */
    public function setAverageMileage(float $mileage): void
    {
        $this->averageMileage = $mileage;
    }

    /**
     * @return float
     */
    public function getAverageYear(): float
    {
        return $this->averageYear;
    }

    /**
     * @param float $year
     * @return void
     */
    public function setAverageYear(float $year): void
    {
        $this->averageYear = $year;
    }
}
