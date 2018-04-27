<?php
/**
 * File: SlugifierInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Slugify;

/**
 * Interface SlugifierInterface
 * @package MSlwk\Otomoto\App\Slugify
 */
interface SlugifierInterface
{
    /**
     * @param string $toSlugify
     * @return string
     */
    public function slugify(string $toSlugify): string;
}
