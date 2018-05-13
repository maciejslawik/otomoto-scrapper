<?php
/**
 * File: ModelUrlSuffixProviderInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Url;

use MSlwk\Otomoto\App\Model\Data\ModelDTOInterface;

/**
 * Interface ModelUrlSuffixProviderInterface
 * @package MSlwk\Otomoto\App\Model\Url
 */
interface ModelUrlSuffixProviderInterface
{
    /**
     * @param ModelDTOInterface $modelDTO
     * @return string
     */
    public function getUrlSuffix(ModelDTOInterface $modelDTO): string;
}
