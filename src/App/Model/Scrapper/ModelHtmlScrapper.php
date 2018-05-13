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
    const HTML_MODEL_DATA_NODE_SELECTOR = 'section#body-container';
    const HTML_MODEL_DATA_NODE_ATTRIBUTE = 'data-facets';
    const MODEL_DATA_JSON_KEY = 'filter_enum_model';

    /**
     * @param string $html
     * @return ModelDTOArray
     */
    public function scrapModels(string $html): ModelDTOArray
    {
        $modelDTOArray = new ModelDTOArray();

        $modelOptions = $this->getModelsElements($html);

        foreach ($modelOptions as $model => $numberOfOffers) {
            $modelDTO = new ModelDTO($model);
            $modelDTOArray->add($modelDTO);
        }

        return $modelDTOArray;
    }

    /**
     * @param string $html
     * @return array
     */
    private function getModelsElements(string $html): array
    {
        $crawler = new Crawler($html);

        $modelListNode = $crawler->filter(self::HTML_MODEL_DATA_NODE_SELECTOR)->getNode(0);
        $jsonData = $modelListNode->getAttribute(self::HTML_MODEL_DATA_NODE_ATTRIBUTE);
        $encodedData = json_decode($jsonData, true);
        return $encodedData[self::MODEL_DATA_JSON_KEY];
    }
}
