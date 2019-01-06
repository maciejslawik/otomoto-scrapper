<?php
/**
 * File: ModelProviderTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Model;

use MSlwk\Otomoto\App\Base\UrlProvider;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTO;
use MSlwk\Otomoto\App\Model\Data\ModelDTOArray;
use MSlwk\Otomoto\App\Model\ModelProvider;
use MSlwk\Otomoto\App\Model\Scrapper\ModelHtmlScrapper;
use MSlwk\Otomoto\App\Model\Validator\ModelsScrappedValidator;
use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ReactPHPRequestAdapter;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Factory\ReactPHP\ReactPHPAdapterFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use MSlwk\Otomoto\App\Manufacturer\Url\ManufacturerUrlSuffixProvider;

/**
 * Class ModelProviderTest
 * @package MSlwk\Otomoto\App\Test\Unit\Model
 */
class ModelProviderTest extends TestCase
{
    /**
     * @var MockObject|ReactPHPAdapterFactory
     */
    private $adapterFactory;

    /**
     * @var MockObject|UrlProvider
     */
    private $urlPovider;

    /**
     * @var MockObject|ModelHtmlScrapper
     */
    private $modelHtmlScrapper;

    /**
     * @var MockObject|ModelsScrappedValidator
     */
    private $modelsScrappedValidator;

    /**
     * @var MockObject|ManufacturerUrlSuffixProvider
     */
    private $manufacturerUrlSuffixProvider;

    /**
     * @var MockObject|ModelProvider
     */
    private $modelProvider;

    /**
     * @var MockObject|ReactPHPRequestAdapter
     */
    private $GETAdapter;

    /**
     * @retun void
     */
    protected function setUp()
    {
        $this->adapterFactory = $this->getMockBuilder(ReactPHPAdapterFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->urlPovider = $this->getMockBuilder(UrlProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->modelHtmlScrapper = $this->getMockBuilder(ModelHtmlScrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->modelsScrappedValidator = $this->getMockBuilder(ModelsScrappedValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->manufacturerUrlSuffixProvider = $this->getMockBuilder(ManufacturerUrlSuffixProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->modelProvider = $this->getMockBuilder(ModelProvider::class)
            ->setConstructorArgs(
                [
                    $this->adapterFactory,
                    $this->urlPovider,
                    $this->modelHtmlScrapper,
                    $this->modelsScrappedValidator,
                    $this->manufacturerUrlSuffixProvider
                ]
            )
            ->setMethods(null)
            ->getMock();

        $this->GETAdapter = $this->getMockBuilder(ReactPHPRequestAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->adapterFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->GETAdapter));
    }

    /**
     * @test
     */
    public function testGetManufacturers()
    {
        $model1 = new ModelDTO('model1');
        $model2 = new ModelDTO('model2');
        $model3 = new ModelDTO('model3');
        $modelDTOArray = new ModelDTOArray($model1, $model2, $model3);
        $manufacturer = new ManufacturerDTO('manufacturer');

        $this->urlPovider->expects($this->once())
            ->method('getBaseUrl')
            ->will($this->returnValue('url'));
        $this->manufacturerUrlSuffixProvider->expects($this->once())
            ->method('getUrlSuffix')
            ->with($manufacturer);
        $this->GETAdapter->expects($this->once())
            ->method('getWebpages')
            ->will($this->returnValue(new WebpageDTOArray(new WebpageDTO('html'))));

        $this->modelHtmlScrapper->expects($this->once())
            ->method('scrapModels')
            ->will($this->returnValue($modelDTOArray));

        $this->modelsScrappedValidator->expects($this->once())
            ->method('validate')
            ->with($modelDTOArray);

        /** @var ModelDTOArray $returnedModels */
        $returnedModels = $this->modelProvider->getModels($manufacturer);

        $this->assertInstanceOf(ModelDTOArray::class, $returnedModels);
        $this->assertEquals($model1->getName(), $returnedModels->current()->getName());
        $this->assertEquals($model3->getName(), $returnedModels->get(2)->getName());
    }
}
