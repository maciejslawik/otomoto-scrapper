<?php
/**
 * File: ManufacturerHtmlScrapper.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Manufacturer\Scrapper;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ManufacturerHtmlScrapper
 * @package MSlwk\Otomoto\App\Manufacturer\Scrapper
 */
class ManufacturerHtmlScrapper implements ManufacturerHtmlScrapperInterface
{
    const MANUFACTURER_SELECT_CSS_SELECTOR = 'select[name="search[filter_enum_make]"]';

    /**
     * @param string $html
     * @return ManufacturerDTOArray
     */
    public function scrapManufacturers(string $html): ManufacturerDTOArray
    {
        $manufacturerDTOArray = new ManufacturerDTOArray();

        $manufacturerSelectOptions = $this->getManufacturersSelectOptions($html);
        $manufacturerSelectOptions->each(function (Crawler $crawler) use (&$manufacturerDTOArray) {
            $optionNode = $crawler->getNode(0);
            if ($optionNode->getAttribute('value')) {
                $manufacturerDTO = new ManufacturerDTO($this->retrieveManufacturerNameFromOptionText($optionNode));
                $manufacturerDTOArray->add($manufacturerDTO);
            }
        });

        return $manufacturerDTOArray;
    }

    /**
     * @param string $html
     * @return Crawler
     */
    private function getManufacturersSelectOptions(string $html): Crawler
    {
        $crawler = new Crawler($html);
        $manufacturerSelectField = $crawler->filter($this->getManufacturerSelectCssSelector())->first();
        $manufacturerSelectOptions = $manufacturerSelectField->children();
        return $manufacturerSelectOptions;
    }

    /**
     * @return string
     */
    private function getManufacturerSelectCssSelector(): string
    {
        return self::MANUFACTURER_SELECT_CSS_SELECTOR;
    }

    /**
     * @param $optionNode
     * @return string
     */
    private function retrieveManufacturerNameFromOptionText($optionNode): string
    {
        return preg_replace('/\s\([^)]+\)/', '', $optionNode->nodeValue);
    }
}
