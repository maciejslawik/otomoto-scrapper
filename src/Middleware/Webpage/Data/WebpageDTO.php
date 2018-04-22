<?php
/**
 * File: WebpageDTO.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Data;

/**
 * Class WebpageDTO
 * @package MSlwk\Otomoto\Middleware\Webpage\Data
 */
class WebpageDTO implements WebpageDTOInterface
{
    /**
     * @var string
     */
    private $html;

    /**
     * WebpageDTO constructor.
     * @param string $html
     */
    public function __construct(string $html)
    {
        $this->html = $html;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}
