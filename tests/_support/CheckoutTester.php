<?php

use Faker\Factory;
use Page\Credentials;

class CheckoutTester extends GlobalTester
{

    /**
     * @throws Exception
     */
    public function goToCheckout()
    {
        $Ch = $this;
        $Ch->waitPageLoad();
        $Ch->waitForElementClickable("//button[@class='action showcart primary blue']", 10);
        $Ch->click("//button[@class='action showcart primary blue']");
        $Ch->executeJS("document.querySelector('[class=\"booking-panel-tab__icon booking-panel-tab__icon--items\"]').click()");
        $Ch->waitForElementClickable("//button[@id='top-cart-btn-checkout']", 10);
        $Ch->click("//button[@id='top-cart-btn-checkout']");
        $Ch->waitPageLoad();
        $Ch->waitForElementClickable("//button[@class= 'button action continue primary']", 10);
        $Ch->click("//button[@class= 'button action continue primary']");
        $Ch->waitPageLoad();
        $Ch->waitAjaxLoad();
        $Ch->see('Extra services we recommend for you', "//li[@id=\"extras\"]//div[@class='step-title']");
        $Ch->waitForElementClickable("//li[@id=\"extras\"]//button[@class= 'button action continue primary']", 10);
        $Ch->click("//li[@id=\"extras\"]//button[@class= 'button action continue primary']");
        $Ch->waitPageLoad();
        $Ch->waitAjaxLoad();
        $Ch->waitForElementClickable('//input[@id="fitment_date"]', 10);
        $Ch->click('//input[@id="fitment_date"]');
        $Ch->waitAjaxLoad();
        try {
            $Ch->tryToClick('//td[@data-handler="selectDay"]/a', 10);
        } catch (exception $e) {
            $Ch->click('//a[@data-handler="next"]');
        }
        $Ch->waitForElementClickable('//td[@data-handler="selectDay"]/a');
        $Ch->click('//td[@data-handler="selectDay"]/a');
        $Ch->wait(2);
        $Ch->see('AM', '//li[@id="schedule"]//button[@class="schedule-time-selector__title-btn active"]');
        $timeCount = $Ch->executeJS('return document.querySelectorAll("div[data-bind=\"visible: meridiem()===\'am\'\"] li button:not([disabled])").length');
        $randTime = rand(1, $timeCount);
        $Ch->click("//div[@data-bind=\"visible: meridiem()==='am'\"]//li[$randTime]//button[not(@disabled=\"true\")]");
        $Ch->waitForElementClickable("//li[@id=\"schedule\"]//button[@class= 'button action continue primary']", 10);
        $Ch->click("//li[@id=\"schedule\"]//button[@class= 'button action continue primary']");
        $Ch->waitPageLoad();
        $Ch->waitAjaxLoad();
        $Ch->see('Review your booking & Pay', '//form[@id="co-payment-form"]//div[@class="step-title"]');

    }

    /**
     * @param string $paymentMethod
     * @throws Exception
     */
    public function paymentMethodByArgument(string $paymentMethod)
    {
        $Ch = $this;
        $Ch->wait(1);
        $Ch->waitPageLoad();
        $Ch->waitAjaxLoad();
        $Ch->waitForElementVisible('div.payment-method');
        $Ch->clickOnElementByCssSelector('label[for="'.$paymentMethod.'"]');
        $Ch->waitAjaxLoad();
        $Ch->wait(3);
    }


}