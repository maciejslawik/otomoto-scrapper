<?php
declare(strict_types=1);

/**
 * File:AverageMileageScrapperTest.php
 *
 * @author Maciej Sławik <maciej.slawik@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace MSlwk\Otomoto\App\Test\Unit\Stats\Scrapper\Data;

use MSlwk\Otomoto\App\Stats\Scrapper\Data\AverageMileageScrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AverageMileageScrapperTest
 * @package MSlwk\Otomoto\App\Test\Unit\Stats\Scrapper\Data
 */
class AverageMileageScrapperTest extends TestCase
{
    use OfferHtmlTrait;

    /**
     * @test
     */
    public function testGetMileage()
    {
        $crawler = new Crawler($this->getOfferHtml());
        $scrapper = new AverageMileageScrapper();

        $expected = 49000.00;
        $result = $scrapper->getAverageData($crawler);

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function testGetMileageWithEmptyValueInOffer()
    {
        $crawler = new Crawler($this->getEmptyMileageOfferHtml());
        $scrapper = new AverageMileageScrapper();

        $expected = 1.00;
        $result = $scrapper->getAverageData($crawler);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return string
     */
    private function getEmptyMileageOfferHtml():string
    {
        return '<article data-ad-id="6029918432" class="offer-item is-row is-active"><div class="offer-item__photo "> <a data-ad-id="6029918432" class="offer-item__photo-link" data-ninja-extradata=\'{"ad_id": "6029918432"}\' rel="nofollow" target="_blank" href="http://allegro.pl/show_item.php?item=7336548253#eea5f2f722" title="BMW M4 bmw m4 full carbon m performance aso head zamiana!" style="background-image: url(\'https://otomotopl-imagestmp.akamaized.net/images_otomotopl/890043202_1_320x240_bmw-m4-full-carbon-m-performance-aso-head-zamiana-rzeszow.jpg\')"> </a> </div><div class="offer-item__content"> <div class="offer-item__title"> <h2 class="offer-title"> <a data-ad-id="6029918432" class="offer-title__link" data-ninja-extradata=\'{"ad_id": "6029918432"}\' rel="nofollow" target="_blank" href="http://allegro.pl/show_item.php?item=7336548253#eea5f2f722" title="bmw m4 full carbon m performance aso head zamiana!"> bmw m4 full carbon m performance aso head zamiana! </a> <div class="favorite-box in-row"> <a href="#" class="favorite-button observe-link observed-6029918432" rel="nofollow" data-statkey="ad.observed.list" data-id="6029918432" data-tracking="favourite_ad_click" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <span class="favorite-button__icon icon-observe_Active" title="Usuń z obserwowanych" data-toggle="tooltip" data-placement="bottom"></span> <span class="favorite-button__icon icon-observe_Inactive" title="Obserwuj" data-toggle="tooltip" data-placement="bottom"></span> </a></div><div class="contact-box visible-xs-block"> <div class="om-button action-button transparent contact-button" href="#" data-tracking="contact_button_click" data-id="6029918432" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <span class="icon-mail"></span> <span class="visible-lg-inline button-text">Kontakt</span> </div><div class="om-contact-layer hidden"> <a class="close-contact-layer icon-zamknij" href=""></a> <form class="quick-contact-form" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <fieldset><div class="title">Wyślij wiadomość</div><div class="om-fbox focusbox"> <input type="text" name="contact[email]" value="" placeholder="Twój e-mail"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_emailError"></small> </p></div><div class="om-fbox focusbox"> <input type="text" name="contact[phone]" placeholder="Podaj swój nr telefonu"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_phoneError"></small> </p></div><div class="om-fbox focusbox"> <textarea name="contact[txt]"></textarea><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_messageError"></small> </p></div><div class="om-fbox clr"> <input class="om-button secondary sendMessageListing" type="submit" value="Wyślij"></div><input type="hidden" class="adId" name="contact[adid]" value="6029918432"></fieldset></form> </div></div></h2> </div><div class="offer-item__price"> <div class="offer-price"> <span class="offer-price__number">229 000 <span class="offer-price__currency">PLN</span> </span> <span class="offer-price__details"> Netto </span> </div></div><ul class="offer-item__params"><li class="offer-item__params-item" data-code="year"> <span>2015 </span> </li><li class="offer-item__params-item" data-code="engine_capacity"> <span>3 000 cm3</span> </li><li class="offer-item__params-item" data-code="fuel_type"> <span>Benzyna</span> </li></ul><div class="offer-item__bottom-row "> <div class="contact-box hidden-xs"> <div class="om-button action-button transparent contact-button" href="#" data-tracking="contact_button_click" data-id="6029918432" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <span class="icon-mail"></span> <span class="visible-lg-inline button-text">Kontakt</span> </div><div class="om-contact-layer hidden"> <a class="close-contact-layer icon-zamknij" href=""></a> <form class="quick-contact-form" data-ninja-extradata=\'{"ad_id": "6029918432"}\'> <fieldset><div class="title">Wyślij wiadomość</div><div class="om-fbox focusbox"> <input type="text" name="contact[email]" value="" placeholder="Twój e-mail"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_emailError"></small> </p></div><div class="om-fbox focusbox"> <input type="text" name="contact[phone]" placeholder="Podaj swój nr telefonu"><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_phoneError"></small> </p></div><div class="om-fbox focusbox"> <textarea name="contact[txt]"></textarea><p class="desc errorboxContainer"> <small class="ca6 lheight24" id="se_messageError"></small> </p></div><div class="om-fbox clr"> <input class="om-button secondary sendMessageListing" type="submit" value="Wyślij"></div><input type="hidden" class="adId" name="contact[adid]" value="6029918432"></fieldset></form> </div></div><span class="offer-item__location"> <span class="icon-location-2"></span> <h4>Rzeszów <em>(Podkarpackie)</em> </h4> </span> </div></div></article>';
    }
}
