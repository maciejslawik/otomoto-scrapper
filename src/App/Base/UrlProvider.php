<?php
/**
 * File: UrlProvider.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Base;

/**
 * Class UrlProvider
 * @package MSlwk\Otomoto\App\Base
 */
class UrlProvider implements UrlPoviderInterface
{
    const OTOMOTO_URL = 'https://www.otomoto.pl';

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return self::OTOMOTO_URL;
    }
}
