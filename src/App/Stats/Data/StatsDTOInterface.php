<?php
/**
 * File: StatsDTOInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Data;

/**
 * Interface StatsDTOInterface
 * @package MSlwk\Otomoto\App\Stats\Data
 */
interface StatsDTOInterface
{
    /**
     * @return float
     */
    public function getAveragePrice(): float;

    /**
     * @param float $price
     * @return void
     */
    public function setAveragePrice(float $price): void;

    /**
     * @return float
     */
    public function getAverageMileage(): float;

    /**
     * @param float $mileage
     * @return void
     */
    public function setAverageMileage(float $mileage): void;

    /**
     * @return float
     */
    public function getAverageYear(): float;

    /**
     * @param float $year
     * @return void
     */
    public function setAverageYear(float $year): void;
}
