<?php
/**
 * File: FileDriverOptionsProviderInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider;

/**
 * Interface FileDriverOptionsProviderInterface
 * @package MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider
 */
interface FileDriverOptionsProviderInterface
{
    /**
     * @return array
     */
    public function getOptions(): array;
}
