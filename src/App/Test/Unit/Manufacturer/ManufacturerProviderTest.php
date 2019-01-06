<?php
/**
 * File: ManufacturerProviderTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\App\Test\Unit\Manufacturer;

use MSlwk\Otomoto\App\Base\UrlProvider;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTO;
use MSlwk\Otomoto\App\Manufacturer\Data\ManufacturerDTOArray;
use MSlwk\Otomoto\App\Manufacturer\ManufacturerProvider;
use MSlwk\Otomoto\App\Manufacturer\Scrapper\ManufacturerHtmlScrapper;
use MSlwk\Otomoto\App\Manufacturer\Validator\ManufacturersScrappedValidator;
use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\ReactPHPRequestAdapter;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Factory\ReactPHP\ReactPHPAdapterFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ManufacturerProviderTest
 * @package MSlwk\Otomoto\App\Test\Unit\Manufacturer
 */
class ManufacturerProviderTest extends TestCase
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
     * @var MockObject|ManufacturerHtmlScrapper
     */
    private $manufacturerHtmlScrapper;

    /**
     * @var MockObject|ManufacturersScrappedValidator
     */
    private $manufacturersScrappedValidator;

    /**
     * @var MockObject|ManufacturerProvider
     */
    private $manufacturerProvider;

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
        $this->manufacturerHtmlScrapper = $this->getMockBuilder(ManufacturerHtmlScrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->manufacturersScrappedValidator = $this->getMockBuilder(ManufacturersScrappedValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->manufacturerProvider = $this->getMockBuilder(ManufacturerProvider::class)
            ->setConstructorArgs(
                [
                    $this->adapterFactory,
                    $this->urlPovider,
                    $this->manufacturerHtmlScrapper,
                    $this->manufacturersScrappedValidator
                ]
            )->setMethods(null)
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
        $manufacturer1 = new ManufacturerDTO('manufacturer1');
        $manufacturer2 = new ManufacturerDTO('manufacturer2');
        $manufacturer3 = new ManufacturerDTO('manufacturer3');
        $manufacturerDTOArray = new ManufacturerDTOArray($manufacturer1, $manufacturer2, $manufacturer3);

        $this->urlPovider->expects($this->once())
            ->method('getBaseUrl')
            ->will($this->returnValue('url'));
        $this->GETAdapter->expects($this->once())
            ->method('getWebpages')
            ->will($this->returnValue(new WebpageDTOArray(new WebpageDTO('html'))));

        $this->manufacturerHtmlScrapper->expects($this->once())
            ->method('scrapManufacturers')
            ->will($this->returnValue($manufacturerDTOArray));

        $this->manufacturersScrappedValidator->expects($this->once())
            ->method('validate')
            ->with($manufacturerDTOArray);

        /** @var ManufacturerDTOArray $returnedManufacturers */
        $returnedManufacturers = $this->manufacturerProvider->getManufacturers();

        $this->assertInstanceOf(ManufacturerDTOArray::class, $returnedManufacturers);
        $this->assertEquals($manufacturer1->getName(), $returnedManufacturers->current()->getName());
        $this->assertEquals($manufacturer3->getName(), $returnedManufacturers->get(2)->getName());
    }
}
