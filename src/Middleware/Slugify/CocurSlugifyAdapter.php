<?php
/**
 * File: CocurSlugifyAdapter.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Slugify;

use MSlwk\Otomoto\App\Slugify\SlugifierInterface;
use Cocur\Slugify\Slugify;

/**
 * Class CocurSlugifyAdapter
 * @package MSlwk\Otomoto\Middleware\Slugify
 */
class CocurSlugifyAdapter implements SlugifierInterface
{
    /**
     * @param string $toSlugify
     * @return string
     */
    public function slugify(string $toSlugify): string
    {
        $slugifier = new Slugify();
        return $slugifier->slugify($toSlugify);
    }
}
