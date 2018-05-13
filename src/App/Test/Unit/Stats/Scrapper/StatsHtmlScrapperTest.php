<?php
declare(strict_types=1);

/**
 * File:StatsHtmlScrapperTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Scrapper;

use MSlwk\Otomoto\App\Exception\OffersNotFoundException;
use MSlwk\Otomoto\App\Stats\Scrapper\Data\AverageDataScrapperInterface;
use MSlwk\Otomoto\App\Stats\Scrapper\StatsHtmlScrapper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class StatsHtmlScrapperTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Scrapper
 */
class StatsHtmlScrapperTest extends TestCase
{
    /**
     * @var MockObject|AverageDataScrapperInterface
     */
    private $mileageScrapper;

    /**
     * @var MockObject|AverageDataScrapperInterface
     */
    private $yearScrapper;

    /**
     * @var MockObject|AverageDataScrapperInterface
     */
    private $priceScrapper;

    /**
     * @var MockObject|StatsHtmlScrapper
     */
    private $statsHtmlScrapper;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->mileageScrapper = $this->getMockBuilder(AverageDataScrapperInterface::class)
            ->getMock();
        $this->yearScrapper = $this->getMockBuilder(AverageDataScrapperInterface::class)
            ->getMock();
        $this->priceScrapper = $this->getMockBuilder(AverageDataScrapperInterface::class)
            ->getMock();

        $this->statsHtmlScrapper = new StatsHtmlScrapper(
            $this->mileageScrapper,
            $this->yearScrapper,
            $this->priceScrapper
        );
    }

    /**
     * @test
     * @dataProvider htmlWithOffersDataProvider
     * @param string $html
     */
    public function testGetStatsWithOffersFound(string $html)
    {
        $this->mileageScrapper->expects($this->exactly(3))
            ->method('getAverageData')
            ->willReturnOnConsecutiveCalls(100.00, 200.00, 300.00);
        $this->priceScrapper->expects($this->exactly(3))
            ->method('getAverageData')
            ->willReturnOnConsecutiveCalls(150.00, 300.00, 450.00);
        $this->yearScrapper->expects($this->exactly(3))
            ->method('getAverageData')
            ->willReturnOnConsecutiveCalls(2016.00, 2017.00, 2018.00);

        $expectedMileage = 200.00;
        $expectedPrice = 300.00;
        $expectedYear = 2017.00;

        $result = $this->statsHtmlScrapper->scrapModelStats($html);

        $this->assertEquals($expectedMileage, $result->getAverageMileage());
        $this->assertEquals($expectedPrice, $result->getAveragePrice());
        $this->assertEquals($expectedYear, $result->getAverageYear());
    }

    /**
     * @test
     * @dataProvider htmlWithoutOffersDataProvider
     * @param string $html
     */
    public function testGetStatsWithoutOffersFound(string $html)
    {
        $this->expectException(OffersNotFoundException::class);
        $this->statsHtmlScrapper->scrapModelStats($html);
    }

    /**
     * @return array
     */
    public function htmlWithOffersDataProvider()
    {
        return [
            [
                '<article data-ad-id="6029918432" class="offer-item is-row is-active"><div class="offer-item__photo "> <a data-ad-id="6029918432" class="offer-item__photo-link" data-ninja-extradata=\'{"ad_id": "6029918432"}\' rel="nofollow" target="_blank" href="http://allegro.pl/show_item.php?item=7336548253#eea5f2f722" title="BMW M4 bmw m4 full carbon m performance aso head zamiana!" style="background-image: url(\'https://otomotopl-imagestmp.akamaized.net/images_otomotopl/890043202_1_320x240_bmw-m4-full-carbon-m-performance-aso-head-zamiana-rzeszow.jpg\')"> </a> </div><div class="offer-item__content"> <div class="offer-item__title"> <h2 class="offer-title"> <a data-ad-id="6029918432" class="offer-title__link" data-ninja-extradata=\'{"ad_id": "6029918432"}\' rel="nofollow" target="_blank" href="http://allegro.pl/show_item.php?item=7336548253#eea5f2f722" title="bmw m4 full carbon m performance aso head zamiana!"> bmw m4 full carbon m performance aso head zamiana! </a> <div class="favorite-box in-row"> <a href="#" class="favorite-button observe-link observed-6029918432" rel="nofollow" data-statkey="ad.observed.list" data-id="6029918432" data-tracking="favourite_ad_click" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <span class="favorite-button__icon icon-observe_Active" title="Usuń z obserwowanych" data-toggle="tooltip" data-placement="bottom"></span> <span class="favorite-button__icon icon-observe_Inactive" title="Obserwuj" data-toggle="tooltip" data-placement="bottom"></span> </a></div><div class="contact-box visible-xs-block"> <div class="om-button action-button transparent contact-button" href="#" data-tracking="contact_button_click" data-id="6029918432" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <span class="icon-mail"></span> <span class="visible-lg-inline button-text">Kontakt</span> </div><div class="om-contact-layer hidden"> <a class="close-contact-layer icon-zamknij" href=""></a> <form class="quick-contact-form" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <fieldset><div class="title">Wyślij wiadomość</div><div class="om-fbox focusbox"> <input type="text" name="contact[email]" value="" placeholder="Twój e-mail"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_emailError"></small> </p></div><div class="om-fbox focusbox"> <input type="text" name="contact[phone]" placeholder="Podaj swój nr telefonu"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_phoneError"></small> </p></div><div class="om-fbox focusbox"> <textarea name="contact[txt]"></textarea><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_messageError"></small> </p></div><div class="om-fbox clr"> <input class="om-button secondary sendMessageListing" type="submit" value="Wyślij"></div><input type="hidden" class="adId" name="contact[adid]" value="6029918432"></fieldset></form> </div></div></h2> </div><div class="offer-item__price"> <div class="offer-price"> <span class="offer-price__number">229 000 <span class="offer-price__currency">PLN</span> </span> <span class="offer-price__details"> Brutto </span> </div></div><ul class="offer-item__params"><li class="offer-item__params-item" data-code="year"> <span>2015 </span> </li><li class="offer-item__params-item" data-code="mileage"> <span>49 000 km</span> </li><li class="offer-item__params-item" data-code="engine_capacity"> <span>3 000 cm3</span> </li><li class="offer-item__params-item" data-code="fuel_type"> <span>Benzyna</span> </li></ul><div class="offer-item__bottom-row "> <div class="contact-box hidden-xs"> <div class="om-button action-button transparent contact-button" href="#" data-tracking="contact_button_click" data-id="6029918432" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <span class="icon-mail"></span> <span class="visible-lg-inline button-text">Kontakt</span> </div><div class="om-contact-layer hidden"> <a class="close-contact-layer icon-zamknij" href=""></a> <form class="quick-contact-form" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <fieldset><div class="title">Wyślij wiadomość</div><div class="om-fbox focusbox"> <input type="text" name="contact[email]" value="" placeholder="Twój e-mail"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_emailError"></small> </p></div><div class="om-fbox focusbox"> <input type="text" name="contact[phone]" placeholder="Podaj swój nr telefonu"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_phoneError"></small> </p></div><div class="om-fbox focusbox"> <textarea name="contact[txt]"></textarea><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_messageError"></small> </p></div><div class="om-fbox clr"> <input class="om-button secondary sendMessageListing" type="submit" value="Wyślij"></div><input type="hidden" class="adId" name="contact[adid]" value="6029918432"></fieldset></form> </div></div><span class="offer-item__location"> <span class="icon-location-2"></span> <h4>Rzeszów <em>(Podkarpackie)</em> </h4> </span> </div></div></article><article data-ad-id="6029739372" class="offer-item is-row is-active"><div class="offer-item__photo "> <a data-ad-id="6029739372" class="offer-item__photo-link" data-ninja-extradata=\'{"ad_id": "6029739372"}\' rel="nofollow" target="_blank" href="http://allegro.pl/show_item.php?item=7333559036#eea5f2f722" title="BMW M4 bmw 540, 540i automat, shadow-line, beżowe skóry," style="background-image: url(\'https://otomotopl-imagestmp.akamaized.net/images_otomotopl/889942957_1_320x240_bmw-540-540i-automat-shadow-line-bezowe-skory-warszawa.jpg\')"> </a> </div><div class="offer-item__content"> <div class="offer-item__title"> <h2 class="offer-title"> <a data-ad-id="6029739372" class="offer-title__link" data-ninja-extradata=\'{"ad_id": "6029739372"}\' rel="nofollow" target="_blank" href="http://allegro.pl/show_item.php?item=7333559036#eea5f2f722" title="bmw 540, 540i automat, shadow-line, beżowe skóry,"> bmw 540, 540i automat, shadow-line, beżowe skóry, </a> <div class="favorite-box in-row"> <a href="#" class="favorite-button observe-link observed-6029739372" rel="nofollow" data-statkey="ad.observed.list" data-id="6029739372" data-tracking="favourite_ad_click" data-ninja-extradata=\'{"ad_id": "6029739372"}\'> <span class="favorite-button__icon icon-observe_Active" title="Usuń z obserwowanych" data-toggle="tooltip" data-placement="bottom"></span> <span class="favorite-button__icon icon-observe_Inactive" title="Obserwuj" data-toggle="tooltip" data-placement="bottom"></span> </a></div><div class="contact-box visible-xs-block"> <div class="om-button action-button transparent contact-button" href="#" data-tracking="contact_button_click" data-id="6029739372" data-ninja-extradata=\'{"ad_id": "6029739372"}\'> <span class="icon-mail"></span> <span class="visible-lg-inline button-text">Kontakt</span> </div><div class="om-contact-layer hidden"> <a class="close-contact-layer icon-zamknij" href=""></a> <form class="quick-contact-form" data-ninja-extradata=\'{"ad_id": "6029739372"}\'> <fieldset><div class="title">Wyślij wiadomość</div><div class="om-fbox focusbox"> <input type="text" name="contact[email]" value="" placeholder="Twój e-mail"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_emailError"></small> </p></div><div class="om-fbox focusbox"> <input type="text" name="contact[phone]" placeholder="Podaj swój nr telefonu"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_phoneError"></small> </p></div><div class="om-fbox focusbox"> <textarea name="contact[txt]"></textarea><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_messageError"></small> </p></div><div class="om-fbox clr"> <input class="om-button secondary sendMessageListing" type="submit" value="Wyślij"></div><input type="hidden" class="adId" name="contact[adid]" value="6029739372"></fieldset></form> </div></div></h2> </div><div class="offer-item__price"> <div class="offer-price"> <span class="offer-price__number">23 500 <span class="offer-price__currency">PLN</span> </span> <span class="offer-price__details"> Brutto </span> </div></div><ul class="offer-item__params"><li class="offer-item__params-item" data-code="year"> <span>1996 </span> </li><li class="offer-item__params-item" data-code="mileage"> <span>170 290 km</span> </li><li class="offer-item__params-item" data-code="engine_capacity"> <span>4 398 cm3</span> </li><li class="offer-item__params-item" data-code="fuel_type"> <span>Benzyna</span> </li></ul><div class="offer-item__bottom-row "> <div class="contact-box hidden-xs"> <div class="om-button action-button transparent contact-button" href="#" data-tracking="contact_button_click" data-id="6029739372" data-ninja-extradata=\'{"ad_id": "6029739372"}\'> <span class="icon-mail"></span> <span class="visible-lg-inline button-text">Kontakt</span> </div><div class="om-contact-layer hidden"> <a class="close-contact-layer icon-zamknij" href=""></a> <form class="quick-contact-form" data-ninja-extradata=\'{"ad_id": "6029739372"}\'> <fieldset><div class="title">Wyślij wiadomość</div><div class="om-fbox focusbox"> <input type="text" name="contact[email]" value="" placeholder="Twój e-mail"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_emailError"></small> </p></div><div class="om-fbox focusbox"> <input type="text" name="contact[phone]" placeholder="Podaj swój nr telefonu"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_phoneError"></small> </p></div><div class="om-fbox focusbox"> <textarea name="contact[txt]"></textarea><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_messageError"></small> </p></div><div class="om-fbox clr"> <input class="om-button secondary sendMessageListing" type="submit" value="Wyślij"></div><input type="hidden" class="adId" name="contact[adid]" value="6029739372"></fieldset></form> </div></div><span class="offer-item__location"> <span class="icon-location-2"></span> <h4>Warszawa <em>(Mazowieckie)</em> </h4> </span> </div></div></article><article data-ad-id="6029256767" class="offer-item is-row is-active"><div class="offer-item__photo "> <a data-ad-id="6029256767" class="offer-item__photo-link" data-ninja-extradata=\'{"ad_id": "6029256767"}\' rel="nofollow" target="_blank" href="http://allegro.pl/show_item.php?item=7322814982#eea5f2f722" title="BMW M4 bmw m4 hud harman full led carbon" style="background-image: url(\'https://otomotopl-imagestmp.akamaized.net/images_otomotopl/888864852_1_320x240_bmw-m4-hud-harman-full-led-carbon-poznan.jpg\')"> </a> </div><div class="offer-item__content"> <div class="offer-item__title"> <h2 class="offer-title"> <a data-ad-id="6029256767" class="offer-title__link" data-ninja-extradata=\'{"ad_id": "6029256767"}\' rel="nofollow" target="_blank" href="http://allegro.pl/show_item.php?item=7322814982#eea5f2f722" title="bmw m4 hud harman full led carbon"> bmw m4 hud harman full led carbon </a> <div class="favorite-box in-row"> <a href="#" class="favorite-button observe-link observed-6029256767" rel="nofollow" data-statkey="ad.observed.list" data-id="6029256767" data-tracking="favourite_ad_click" data-ninja-extradata=\'{"ad_id": "6029256767"}\'> <span class="favorite-button__icon icon-observe_Active" title="Usuń z obserwowanych" data-toggle="tooltip" data-placement="bottom"></span> <span class="favorite-button__icon icon-observe_Inactive" title="Obserwuj" data-toggle="tooltip" data-placement="bottom"></span> </a></div><div class="contact-box visible-xs-block"> <div class="om-button action-button transparent contact-button" href="#" data-tracking="contact_button_click" data-id="6029256767" data-ninja-extradata=\'{"ad_id": "6029256767"}\'> <span class="icon-mail"></span> <span class="visible-lg-inline button-text">Kontakt</span> </div><div class="om-contact-layer hidden"> <a class="close-contact-layer icon-zamknij" href=""></a> <form class="quick-contact-form" data-ninja-extradata=\'{"ad_id": "6029256767"}\'> <fieldset><div class="title">Wyślij wiadomość</div><div class="om-fbox focusbox"> <input type="text" name="contact[email]" value="" placeholder="Twój e-mail"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_emailError"></small> </p></div><div class="om-fbox focusbox"> <input type="text" name="contact[phone]" placeholder="Podaj swój nr telefonu"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_phoneError"></small> </p></div><div class="om-fbox focusbox"> <textarea name="contact[txt]"></textarea><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_messageError"></small> </p></div><div class="om-fbox clr"> <input class="om-button secondary sendMessageListing" type="submit" value="Wyślij"></div><input type="hidden" class="adId" name="contact[adid]" value="6029256767"></fieldset></form> </div></div></h2> </div><div class="offer-item__price"> <div class="offer-price"> <span class="offer-price__number">255 500 <span class="offer-price__currency">PLN</span> </span> <span class="offer-price__details"> Brutto </span> </div></div><ul class="offer-item__params"><li class="offer-item__params-item" data-code="year"> <span>2016 </span> </li><li class="offer-item__params-item" data-code="mileage"> <span>15 800 km</span> </li><li class="offer-item__params-item" data-code="engine_capacity"> <span>2 998 cm3</span> </li><li class="offer-item__params-item" data-code="fuel_type"> <span>Benzyna</span> </li></ul><div class="offer-item__bottom-row "> <div class="contact-box hidden-xs"> <div class="om-button action-button transparent contact-button" href="#" data-tracking="contact_button_click" data-id="6029256767" data-ninja-extradata=\'{"ad_id": "6029256767"}\'> <span class="icon-mail"></span> <span class="visible-lg-inline button-text">Kontakt</span> </div><div class="om-contact-layer hidden"> <a class="close-contact-layer icon-zamknij" href=""></a> <form class="quick-contact-form" data-ninja-extradata=\'{"ad_id": "6029256767"}\'> <fieldset><div class="title">Wyślij wiadomość</div><div class="om-fbox focusbox"> <input type="text" name="contact[email]" value="" placeholder="Twój e-mail"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_emailError"></small> </p></div><div class="om-fbox focusbox"> <input type="text" name="contact[phone]" placeholder="Podaj swój nr telefonu"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_phoneError"></small> </p></div><div class="om-fbox focusbox"> <textarea name="contact[txt]"></textarea><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_messageError"></small> </p></div><div class="om-fbox clr"> <input class="om-button secondary sendMessageListing" type="submit" value="Wyślij"></div><input type="hidden" class="adId" name="contact[adid]" value="6029256767"></fieldset></form> </div></div><span class="offer-item__location"> <span class="icon-location-2"></span> <h4>Poznań <em>(Wielkopolskie)</em> </h4> </span> </div></div></article>'
            ]
        ];
    }

    /**
     * @return array
     */
    public function htmlWithoutOffersDataProvider()
    {
        return [
            [
                '<html></html>'
            ]
        ];
    }
}
