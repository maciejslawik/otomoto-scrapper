<?php
/**
 * File: ModelOffersHtmlProvider.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Stats;

use MSlwk\Otomoto\App\Base\UrlPoviderInterface;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOInterface;
use MSlwk\Otomoto\App\Manufacturer\Url\ManufacturerUrlSuffixProviderInterface;
use MSlwk\Otomoto\App\Model\Data\ModelDTOInterface;
use MSlwk\Otomoto\App\Model\Url\ModelUrlSuffixProviderInterface;
use MSlwk\Otomoto\App\Stats\Filter\FilterArray;
use MSlwk\Otomoto\App\Stats\Filter\FilterInterface;
use MSlwk\Otomoto\App\Stats\Pager\PagerInterface;
use MSlwk\Otomoto\Middleware\Webpage\Adapter\GETHandlerInterface;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTOInterface;
use MSlwk\Otomoto\Middleware\Webpage\Factory\GETHandlerAdapterFactoryInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ModelOffersHtmlProvider
 * @package MSlwk\Otomoto\App\Stats
 */
class ModelOffersHtmlProvider
{
    const HTML_PAGER_SELECTOR = 'ul.om-pager';
    const HTML_PAGER_ELEMENT_SELECTOR = 'span.page';
    const HTML_OFFER_LIST_SELECTOR = 'div.offers.list';

    /**
     * @var GETHandlerAdapterFactoryInterface
     */
    private $adapterFactory;

    /**
     * @var UrlPoviderInterface
     */
    private $urlPovider;

    /**
     * @var ManufacturerUrlSuffixProviderInterface
     */
    private $manufacturerUrlSuffixProvider;

    /**
     * @var ModelUrlSuffixProviderInterface
     */
    private $modelUrlSuffixProvider;

    /**
     * @var PagerInterface
     */
    private $pager;

    /**
     * @var GETHandlerInterface
     */
    private $GETAdapter;

    /**
     * ModelOffersHtmlProvider constructor.
     * @param GETHandlerAdapterFactoryInterface $adapterFactory
     * @param UrlPoviderInterface $urlPovider
     * @param ManufacturerUrlSuffixProviderInterface $manufacturerUrlSuffixProvider
     * @param ModelUrlSuffixProviderInterface $modelUrlSuffixProvider
     * @param PagerInterface $pager
     */
    public function __construct(
        GETHandlerAdapterFactoryInterface $adapterFactory,
        UrlPoviderInterface $urlPovider,
        ManufacturerUrlSuffixProviderInterface $manufacturerUrlSuffixProvider,
        ModelUrlSuffixProviderInterface $modelUrlSuffixProvider,
        PagerInterface $pager
    ) {
        $this->adapterFactory = $adapterFactory;
        $this->urlPovider = $urlPovider;
        $this->manufacturerUrlSuffixProvider = $manufacturerUrlSuffixProvider;
        $this->modelUrlSuffixProvider = $modelUrlSuffixProvider;
        $this->pager = $pager;
    }

    /**
     * @param ManufacturerDTOInterface $manufacturer
     * @param ModelDTOInterface $model
     * @param FilterArray $filters
     * @return string
     */
    public function getAllPagesHtml(
        ManufacturerDTOInterface $manufacturer,
        ModelDTOInterface $model,
        FilterArray $filters
    ): string {
        $baseUrl = $this->buildBaseUrl($manufacturer, $model, $filters);
        $this->GETAdapter = $this->adapterFactory->create();

        $baseUrlDTO = new UrlDTOArray(new UrlDTO($baseUrl));
        $baseWebpageDTO = $this->GETAdapter->getWebpages($baseUrlDTO)->current();

        $lastPage = $this->getLastPageNumber($baseWebpageDTO);
        $allPagesDTOs = new WebpageDTOArray();
        if ($lastPage >= 2) {
            $allPagesDTOs = $this->getNextPages($lastPage, $baseUrl);
        }
        $allPagesDTOs->add($baseWebpageDTO);

        $html = $this->extractOffersHtml($allPagesDTOs);

        return $html;
    }

    /**
     * @param ManufacturerDTOInterface $manufacturer
     * @param ModelDTOInterface $model
     * @param FilterArray $filters
     * @return string
     */
    private function buildBaseUrl(
        ManufacturerDTOInterface $manufacturer,
        ModelDTOInterface $model,
        FilterArray $filters
    ): string {
        $baseUrl = $this->urlPovider->getBaseUrl();
        $baseUrl .= $this->manufacturerUrlSuffixProvider->getUrlSuffix($manufacturer);
        $baseUrl .= $this->modelUrlSuffixProvider->getUrlSuffix($model);
        $baseUrl .= '?';
        /** @var FilterInterface $filter */
        foreach ($filters as $filter) {
            $baseUrl .= "{$filter->getName()}={$filter->getValue()}&";
        }
        return $baseUrl;
    }

    /**
     * @param WebpageDTOInterface $baseWebpageDTO
     * @return int
     */
    private function getLastPageNumber(WebpageDTOInterface $baseWebpageDTO): int
    {
        $crawler = new Crawler($baseWebpageDTO->getHtml());
        $pagerListItems = $crawler
            ->filter(self::HTML_PAGER_SELECTOR)
            ->filter(self::HTML_PAGER_ELEMENT_SELECTOR);
        $lastPagerItem = $pagerListItems->getNode($pagerListItems->count() - 2);
        return $lastPagerItem ? (int)$lastPagerItem->textContent : 0;
    }

    /**
     * @param int $lastPage
     * @param string $baseUrl
     * @return WebpageDTOArray
     */
    private function getNextPages(int $lastPage, string $baseUrl): WebpageDTOArray
    {
        $urlDTOs = new UrlDTOArray();
        for ($i = 2; $i <= $lastPage; $i++) {
            $urlDTO = new UrlDTO($baseUrl . $this->pager->getPagerParameter($i));
            $urlDTOs->add($urlDTO);
        }

        $allPagesDTOs = $this->GETAdapter->getWebpages($urlDTOs);
        return $allPagesDTOs;
    }

    /**
     * @param WebpageDTOArray $allPagesDTOs
     * @return string
     */
    private function extractOffersHtml(WebpageDTOArray $allPagesDTOs): string
    {
        $html = '';
        foreach ($allPagesDTOs as $pageDTO) {
            $crawler = new Crawler($pageDTO->getHtml());
            $offersList = $crawler->filter(self::HTML_OFFER_LIST_SELECTOR);
            if ($offersList->count()) {
                $html .= $offersList->html();
            }
        }
        return $html;
    }
}
