<?php
/**
 * File: ModelHtmlScrapper.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model\Scrapper;

use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ModelHtmlScrapper
 * @package MSlwk\Otomoto\App\Model\Scrapper
 */
class ModelHtmlScrapper implements ModelHtmlScrapperInterface
{
    const MODEL_GROUP_ELEMENT_SELECTOR = 'div#topLinkShowAllList';
    const MODEL_SINGLE_ELEMENT_SELECTOR = 'a.topLink';

    /**
     * @param string $html
     * @return ModelDTOArray
     */
    public function scrapModels(string $html): ModelDTOArray
    {
        $modelDTOArray = new ModelDTOArray();

        $modelOptions = $this->getModelsElements($html);

        $modelOptions->each(function (Crawler $crawler) use (&$modelDTOArray) {
            $optionNode = $crawler->getNode(0);
            if ($optionNode->getAttribute('title')) {
                $modelDTO = new ModelDTO($optionNode->getAttribute('title'));
                $modelDTOArray->add($modelDTO);
            }
        });

        return $modelDTOArray;
    }

    /**
     * @param string $html
     * @return Crawler
     */
    private function getModelsElements(string $html): Crawler
    {
        $crawler = new Crawler($html);

        $modelList = $crawler->filter($this->getModelGroupCssSelector())->first();
        $modelListElements = $modelList->filter($this->getModelSingleCssSelector());
        return $modelListElements;
    }

    /**
     * @return string
     */
    private function getModelGroupCssSelector(): string
    {
        return self::MODEL_GROUP_ELEMENT_SELECTOR;
    }

    /**
     * @return string
     */
    private function getModelSingleCssSelector(): string
    {
        return self::MODEL_SINGLE_ELEMENT_SELECTOR;
    }
}
