<?php
/**
 * File: ManufacturerFactory.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\App\Manufacturer;

use MSlwk\Otomoto\App\Base\UrlProvider;
use MSlwk\Otomoto\App\Manufacturer\ManufacturerProvider;
use MSlwk\Otomoto\App\Manufacturer\Scrapper\ManufacturerHtmlScrapper;
use MSlwk\Otomoto\App\Manufacturer\Validator\ManufacturersScrappedValidator;
use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapterInterface;
use MSlwk\Otomoto\Middleware\Cache\Factory\File\FileCacheAdapterFactory;
use MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider\FileDriverOptionsProvider;
use MSlwk\Otomoto\Middleware\Webpage\Factory\ReactPHP\ReactPHPAdapterFactory;

/**
 * Class ManufacturerFactory
 * @package MSlwk\Otomoto\Middleware\App\Manufacturer
 */
class ManufacturerFactory
{
    /**
     * @return Manufacturer
     */
    public function create(): Manufacturer
    {
        return new Manufacturer(
            $this->getCacheAdapter(),
            $this->getManufacturerProvider(),
            $this->getManufacturerSerializer()
        );
    }

    /**
     * @return CacheAdapterInterface
     */
    private function getCacheAdapter(): CacheAdapterInterface
    {
        $cacheAdapterFactory = new FileCacheAdapterFactory(new FileDriverOptionsProvider());

        return $cacheAdapterFactory->createAdapter();
    }

    /**
     * @return ManufacturerProvider
     */
    private function getManufacturerProvider(): ManufacturerProvider
    {
        $adapterFactory = new ReactPHPAdapterFactory();
        $urlProvider = new UrlProvider();
        $manufacturerHtmlScrapper = new ManufacturerHtmlScrapper();
        $manufacturerScrapperValidator = new ManufacturersScrappedValidator();

        return new ManufacturerProvider(
            $adapterFactory,
            $urlProvider,
            $manufacturerHtmlScrapper,
            $manufacturerScrapperValidator
        );
    }

    /**
     * @return ManufacturerSerializer
     */
    private function getManufacturerSerializer(): ManufacturerSerializer
    {
        return new ManufacturerSerializer();
    }
}
