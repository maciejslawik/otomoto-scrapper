<?php
/**
 * File: ModelUrlSuffixProvider.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Url;

use MSlwk\Otomoto\App\Model\Data\ModelDTOInterface;
use MSlwk\Otomoto\App\Slugify\SlugifierInterface;

/**
 * Class ModelUrlSuffixProvider
 * @package MSlwk\Otomoto\App\Model\Url
 */
class ModelUrlSuffixProvider implements ModelUrlSuffixProviderInterface
{
    /**
     * @var SlugifierInterface
     */
    private $slugifier;

    /**
     * ModelUrlSuffixProvider constructor.
     * @param SlugifierInterface $slugifier
     */
    public function __construct(SlugifierInterface $slugifier)
    {
        $this->slugifier = $slugifier;
    }

    /**
     * @param ModelDTOInterface $modelDTO
     * @return string
     */
    public function getUrlSuffix(ModelDTOInterface $modelDTO): string
    {
        return "{$this->slugifier->slugify($modelDTO->getName())}/";
    }
}
