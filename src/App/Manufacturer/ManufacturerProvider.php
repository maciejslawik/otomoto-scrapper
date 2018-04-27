<?php
/**
 * File: ManufacturerProvider.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Manufacturer;

use MSlwk\Otomoto\App\Base\UrlPoviderInterface;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use MSlwk\Otomoto\App\Manufacturer\Scrapper\ManufacturerHtmlScrapperInterface;
use MSlwk\Otomoto\App\Manufacturer\Validator\ManufacturersScrappedValidatorInterface;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Factory\GETHandlerAdapterFactoryInterface;

/**
 * Class ManufacturerProvider
 * @package MSlwk\Otomoto\App\Manufacturer
 */
class ManufacturerProvider
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
     * @var ManufacturerHtmlScrapperInterface
     */
    private $manufacturerHtmlScrapper;

    /**
     * @var ManufacturersScrappedValidatorInterface
     */
    private $manufacturersScrappedValidator;

    /**
     * ManufacturerScrapper constructor.
     * @param GETHandlerAdapterFactoryInterface $adapterFactory
     * @param UrlPoviderInterface $urlPovider
     * @param ManufacturerHtmlScrapperInterface $manufacturerHtmlScrapper
     * @param ManufacturersScrappedValidatorInterface $manufacturersScrappedValidator
     */
    public function __construct(
        GETHandlerAdapterFactoryInterface $adapterFactory,
        UrlPoviderInterface $urlPovider,
        ManufacturerHtmlScrapperInterface $manufacturerHtmlScrapper,
        ManufacturersScrappedValidatorInterface $manufacturersScrappedValidator
    ) {
        $this->adapterFactory = $adapterFactory;
        $this->urlPovider = $urlPovider;
        $this->manufacturerHtmlScrapper = $manufacturerHtmlScrapper;
        $this->manufacturersScrappedValidator = $manufacturersScrappedValidator;
    }

    /**
     * @return ManufacturerDTOArray
     */
    public function getManufacturers(): ManufacturerDTOArray
    {
        $GETAdapter = $this->adapterFactory->create();

        $urlDTO = new UrlDTO($this->urlPovider->getBaseUrl());
        $urlDTOArray = new UrlDTOArray($urlDTO);
        $homepageHtmlDTO = $GETAdapter->getWebpages($urlDTOArray)->current();
        $manufacturers = $this->manufacturerHtmlScrapper->scrapManufacturers($homepageHtmlDTO->getHtml());

        $this->manufacturersScrappedValidator->validate($manufacturers);

        return $manufacturers;
    }
}
