<?php
/**
 * File: UrlDTO.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Data;

/**
 * Class UrlDTO
 * @package MSlwk\Otomoto\Middleware\Webpage\Data
 */
class UrlDTO implements UrlDTOInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * UrlDTO constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
