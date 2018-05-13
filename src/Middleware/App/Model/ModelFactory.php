<?php
/**
 * File: ModelFactory.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\App\Model;

use MSlwk\Otomoto\App\Base\UrlProvider;
use MSlwk\Otomoto\App\Model\ModelProvider;
use MSlwk\Otomoto\App\Model\Scrapper\ModelHtmlScrapper;
use MSlwk\Otomoto\App\Manufacturer\Url\ManufacturerUrlSuffixProvider;
use MSlwk\Otomoto\App\Model\Validator\ModelsScrappedValidator;
use MSlwk\Otomoto\Middleware\Cache\Adapter\CacheAdapterInterface;
use MSlwk\Otomoto\Middleware\Cache\Factory\File\FileCacheAdapterFactory;
use MSlwk\Otomoto\Middleware\Cache\Factory\File\OptionsProvider\FileDriverOptionsProvider;
use MSlwk\Otomoto\Middleware\Slugify\CocurSlugifyAdapter;
use MSlwk\Otomoto\Middleware\Webpage\Factory\ReactPHP\ReactPHPAdapterFactory;

/**
 * Class ModelFactory
 * @package MSlwk\Otomoto\Middleware\App\Model
 */
class ModelFactory
{
    /**
     * @return Model
     */
    public function create(): Model
    {
        return new Model(
            $this->getCacheAdapter(),
            $this->getModelProvider(),
            $this->getModelSerializer()
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
     * @return ModelProvider
     */
    private function getModelProvider(): ModelProvider
    {
        $adapterFactory = new ReactPHPAdapterFactory();
        $urlProvider = new UrlProvider();
        $modelHtmlScrapper = new ModelHtmlScrapper();
        $modelScrapperValidator = new ModelsScrappedValidator();
        $manufacturerUrlSuffixProvider = new ManufacturerUrlSuffixProvider(new CocurSlugifyAdapter());

        return new ModelProvider(
            $adapterFactory,
            $urlProvider,
            $modelHtmlScrapper,
            $modelScrapperValidator,
            $manufacturerUrlSuffixProvider
        );
    }

    /**
     * @return ModelSerializer
     */
    private function getModelSerializer(): ModelSerializer
    {
        return new ModelSerializer();
    }
}
