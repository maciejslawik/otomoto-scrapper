<?php
/**
 * File: ModelProvider.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Model;

use MSlwk\Otomoto\App\Base\UrlPoviderInterface;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use MSlwk\Otomoto\App\Model\Scrapper\ModelHtmlScrapperInterface;
use MSlwk\Otomoto\App\Model\Url\ManufacturerUrlSuffixProviderInterface;
use MSlwk\Otomoto\App\Model\Validator\ModelsScrappedValidatorInterface;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Factory\GETHandlerAdapterFactoryInterface;

/**
 * Class ModelProvider
 * @package MSlwk\Otomoto\App\Model
 */
class ModelProvider
{
    /**
     * @var GETHandlerAdapterFactoryInterface
     */
    private $adapterFactory;

    /**
     * @var UrlPoviderInterface
     */
    private $urlPovider;

    /**
     * @var ModelHtmlScrapperInterface
     */
    private $modelHtmlScrapper;

    /**
     * @var ModelsScrappedValidatorInterface
     */
    private $modelsScrappedValidator;

    /**
     * @var ManufacturerUrlSuffixProviderInterface
     */
    private $manufacturerUrlSuffixProvider;

    /**
     * ModelProvider constructor.
     * @param GETHandlerAdapterFactoryInterface $adapterFactory
     * @param UrlPoviderInterface $urlPovider
     * @param ModelHtmlScrapperInterface $modelHtmlScrapper
     * @param ModelsScrappedValidatorInterface $modelsScrappedValidator
     * @param ManufacturerUrlSuffixProviderInterface $manufacturerUrlSuffixProvider
     */
    public function __construct(
        GETHandlerAdapterFactoryInterface $adapterFactory,
        UrlPoviderInterface $urlPovider,
        ModelHtmlScrapperInterface $modelHtmlScrapper,
        ModelsScrappedValidatorInterface $modelsScrappedValidator,
        ManufacturerUrlSuffixProviderInterface $manufacturerUrlSuffixProvider
    ) {
        $this->adapterFactory = $adapterFactory;
        $this->urlPovider = $urlPovider;
        $this->modelHtmlScrapper = $modelHtmlScrapper;
        $this->modelsScrappedValidator = $modelsScrappedValidator;
        $this->manufacturerUrlSuffixProvider = $manufacturerUrlSuffixProvider;
    }

    /**
     * @param ManufacturerDTOInterface $manufacturer
     * @return ModelDTOArray
     */
    public function getModels(ManufacturerDTOInterface $manufacturer): ModelDTOArray
    {
        $GETAdapter = $this->adapterFactory->create();

        $url = $this->urlPovider->getBaseUrl() . $this->manufacturerUrlSuffixProvider->getUrlSuffix($manufacturer);
        $urlDTO = new UrlDTO($url);
        $urlDTOArray = new UrlDTOArray($urlDTO);
        $homepageHtmlDTO = $GETAdapter->getWebpages($urlDTOArray)->current();

        $models = $this->modelHtmlScrapper->scrapModels($homepageHtmlDTO->getHtml());

        $this->modelsScrappedValidator->validate($models);

        return $models;
    }
}
