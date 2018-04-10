<?php
/**
 * File: FileDriverOptionsProvider.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider;

/**
 * Class FileDriverOptionsProvider
 * @package MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider
 */
class FileDriverOptionsProvider implements FileDriverOptionsProviderInterface
{
    const DRIVER_OPTIONS = [
        'path' => __DIR__ . '/../../../../../../cache'
    ];

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return self::DRIVER_OPTIONS;
    }
}
