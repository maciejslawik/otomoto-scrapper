<?php
/**
 * File: FilterInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats\Filter;

/**
 * Interface FilterInterface
 * @package MSlwk\Otomoto\App\Stats\Filter
 */
interface FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void;
}
