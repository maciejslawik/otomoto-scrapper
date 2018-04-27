<?php
/**
 * File: ManufacturerUrlSuffixProvider.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Url;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Slugify\SlugifierInterface;

/**
 * Class ManufacturerUrlSuffixProvider
 * @package MSlwk\Otomoto\App\Model\Url
 */
class ManufacturerUrlSuffixProvider implements ManufacturerUrlSuffixProviderInterface
{
    /**
     * @var SlugifierInterface
     */
    private $slugifier;

    /**
     * ManufacturerUrlSuffixProvider constructor.
     * @param SlugifierInterface $slugifier
     */
    public function __construct(SlugifierInterface $slugifier)
    {
        $this->slugifier = $slugifier;
    }

    /**
     * @param ManufacturerDTOInterface $manufacturerDTO
     * @return mixed
     */
    public function getUrlSuffix(ManufacturerDTOInterface $manufacturerDTO)
    {
        return "/osobowe/{$this->slugifier->slugify($manufacturerDTO->getName())}/";
    }
}
