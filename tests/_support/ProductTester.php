<?php

use Page\Credentials;

class ProductTester extends GlobalTester
{

//    /**
//     * @throws Exception
//     */
//    public function openQuickViewForRandomProduct()
//    {
//        $P = $this;
//        $productsCount = $P->getElementsCountByCssSelector('a.product span.product-image-container:first-child span div.bss-bt-quickview a');
//        $randomProductNumber = rand(0, $productsCount - 1);
//        $P->executeJS('document.querySelectorAll("a.product span.product-image-container:first-child span div.bss-bt-quickview a")[' . $randomProductNumber . '].click()');
//        $P->waitForElementNotVisible('.mfp-preloader', 10);
//        $P->switchToIFrame('.mfp-iframe');
//        $P->waitForElementClickable('#product-addtocart-button', 10);
//        $P->seeElement('#product-addtocart-button');
//        $P->switchToIFrame();
//    }

    /**
     * @throws Exception
     */
    public function openRandomProduct()
    {
        $P = $this;
        $P->waitPageLoad(10);
        $productsCount = $P->getElementsCountByCssSelector('a[class ="action primary black"]');
        $randomProductNumber = rand(1, $productsCount);
        $P->waitForElementClickable("//a[@class='action primary black'][$randomProductNumber]", 10);
        $productLink = $P->grabAttributeFrom("//a[@class='action primary black'][$randomProductNumber]", 'href');
        $productLink = str_replace(Credentials::$URL, '', $productLink);
        $P->click("//a[@class='action primary black'][$randomProductNumber]");
        $P->waitPageLoad();
        $P->seeInCurrentUrl($productLink);
        $P->waitForElementVisible("h1.page-title", 30);
    }

    /**
     * @throws Exception
     */
    public function selectRandomOption()
    {
        $P = $this;
        $P->waitPageLoad();
        if (!$P->canSeeElement('div[class="field qty"]')) {
            $P->waitForElementVisible('select.super-attribute-select', 10);
            $P->seeElement('select.super-attribute-select');
            $selectCount = $P->getElementsCountByCssSelector("select.super-attribute-select"); //Get elements count by selector
            for ($selectByIndex = 1; $selectByIndex <= $selectCount; $selectByIndex++) { //Start cycle for select
                $P->seeElement('(//select[contains(@id,"attribute")])[' . $selectByIndex . ']'); //Check select by index availability
                $optionValueCount = $this->getElementsCountByCssSelector('select.super-attribute-select:nth-child(' . $selectByIndex . ')>option');
                $optionValueNumber = rand(1, $optionValueCount);
                $optionValue = $P->grabTextFrom('(//select[contains(@id,"attribute")])[' . $selectByIndex . ']//option[' . $optionValueNumber . ']'); //Writing variable with desired option
                if ($optionValue === "Select Size") {
                    $optionValueNumber += $optionValueNumber;
                    $optionValue = $P->grabTextFrom('(//select[contains(@id,"attribute")])[' . $selectByIndex . ']//option[' . $optionValueNumber . ']'); //Writing variable with desired option
                }
                $P->selectOption('(//select[contains(@id,"attribute")])[' . $selectByIndex . ']', $optionValue); //Select desired option
                $P->see($optionValue, '(//select[contains(@id,"attribute")])[' . $selectByIndex . ']');
            }
        }
    }

    /**
     * @throws Exception
     */
    public function selectRandomQTY()
    {
        $P = $this;
        $P->waitForElementVisible('select#qty', 10);
        $P->seeElement('select#qty');
        $QTYValueCount = $this->getElementsCountByCssSelector('select#qty>option');
        $QTYValueNumber = rand(1, $QTYValueCount);
        $QTYValue = $P->grabTextFrom('(//select[contains(@id,"qty")])//option[' . $QTYValueNumber . ']'); //Writing variable with desired option
        $P->selectOption('(//select[contains(@id,"qty")])', $QTYValue); //Select desired option
        $P->wait(1);
        $P->see($QTYValue, '(//select[contains(@id,"qty")])');
    }


    /**
     * @throws Exception
     */
    public function addProductToCart()
    {
        $P = $this;
        $productCountBefore = $P->grabTextFrom('a.showcart span.counter-number');
        $P->waitForElementClickable('#product-addtocart-button', 10);
        $productTitle = $P->executeJS("return document.querySelector('h1.page-title>span').textContent");
        $productQTY = $P->grabTextFrom('#select2-qty-container');
        $P->click("#product-addtocart-button");
        $P->waitForText('ADDED', 10, '#product-addtocart-button span');
        $P->see('ADDED', '#product-addtocart-button span');
        $P->waitForElementNotVisible('.loading-mask', 10);
        $P->waitForElementVisible('a.showcart span.counter-number', 10);
        $productCountAfter = $P->grabTextFrom('a.showcart span.counter-number');
        if ((int)$productCountAfter === (int)$productCountBefore + (int)$productQTY) {
            $P->click('a.showcart');
            $P->waitForElementVisible('.product-item__name a', 10);
            $P->see($productTitle, '.product-item__name a');
            $P->click('#btn-minicart-close');
        } else {
            throw new Exception("Cart qty doesn't change");
        }
    }

    /**
     * @throws Exception
     */
    public function selectRandomOptionOnQuickView()
    {
        $P = $this;
        $P->switchToIFrame('.mfp-iframe');
        $P->waitForElementVisible('select.super-attribute-select', 10);
        $P->seeElement('select.super-attribute-select');
        $selectCount = $P->getElementsCountByCssSelector("select.super-attribute-select"); //Get elements count by selector
        for ($selectByIndex = 1; $selectByIndex <= $selectCount; $selectByIndex++) { //Start cycle for select
            $P->seeElement('(//select[contains(@id,"attribute")])[' . $selectByIndex . ']'); //Check select by index availability
            $optionValueCount = $this->getElementsCountByCssSelector('select.super-attribute-select:nth-child(' . $selectByIndex . ')>option');
            $optionValueNumber = rand(1, $optionValueCount - 1);
            $optionValue = $P->grabTextFrom('(//select[contains(@id,"attribute")])[' . $selectByIndex . ']//option[' . $optionValueNumber . ']'); //Writing variable with desired option
            if ($optionValue === "Select Size") {
                $optionValueNumber += $optionValueNumber;
                $optionValue = $P->grabTextFrom('(//select[contains(@id,"attribute")])[' . $selectByIndex . ']//option[' . $optionValueNumber . ']'); //Writing variable with desired option
            }
            $P->selectOption('(//select[contains(@id,"attribute")])[' . $selectByIndex . ']', $optionValue); //Select desired option
            $P->see($optionValue, '(//select[contains(@id,"attribute")])[' . $selectByIndex . ']');
        }
        $P->switchToIFrame();
    }

    /**
     * @throws Exception
     */
    public function selectRandomQTYOnQuickView()
    {
        $P = $this;
        $P->switchToIFrame('.mfp-iframe');
        $P->waitForElementVisible('select#qty', 10);
        $P->seeElement('select#qty');
        $QTYValueCount = $this->getElementsCountByCssSelector('select#qty>option');
        $QTYValueNumber = rand(1, $QTYValueCount);
        $QTYValue = $P->grabTextFrom('(//select[contains(@id,"qty")])//option[' . $QTYValueNumber . ']'); //Writing variable with desired option
        $P->selectOption('(//select[contains(@id,"qty")])', $QTYValue); //Select desired option
        $P->wait(1);
        $P->see($QTYValue, '(//select[contains(@id,"qty")])');
        $P->switchToIFrame();
    }

    /**
     * @throws Exception
     */
    public function addProductToCartOnQuickView()
    {
        $P = $this;
        $productCountBefore = $P->grabTextFrom('a.showcart span.counter-number');
        $P->switchToIFrame('.mfp-iframe');
        $P->waitForElementClickable('#product-addtocart-button', 10);
        $productTitle = $P->executeJS("return document.querySelector('h1.page-title>span').textContent");
        $productQTY = $P->grabTextFrom('#select2-qty-container');
        $P->click("#product-addtocart-button");
        $P->waitForText('ADDED', 10, '#product-addtocart-button span');
        $P->see('ADDED', '#product-addtocart-button span');
        $P->switchToIFrame();
        $P->click('.mfp-close');
        $P->waitForElementNotVisible('.loading-mask', 10);
        $P->waitForElementVisible('a.showcart span.counter-number', 10);
        $productCountAfter = $P->grabTextFrom('a.showcart span.counter-number');
        if ((int)$productCountAfter === (int)$productCountBefore + (int)$productQTY) {
            $P->click('a.showcart');
            $P->waitForElementVisible('.product-item__name a', 10);
            $P->see($productTitle, '.product-item__name a');
            $P->click('#btn-minicart-close');
        } else {
            throw new Exception("Cart qty doesn't change");
        }
    }

    /**
     * @throws Exception
     */
    public function addRandomProductToWishListOnQuickView() //TODO Дописать когда вишлист будет работать корректно.
    {
        $P = $this;
        $productWishListCountBefore = $P->grabTextFrom('.wishlist a .counter.qty');
        $P->switchToIFrame('.mfp-iframe');
        $P->waitForElementClickable('.towishlist');
        $productTitle = $P->grabTextFrom('h1.page-title>span');
        $P->click('.towishlist');
        $P->click('.mfp-close');
        $P->switchToIFrame();
        $productWishListCountAfter = $P->grabTextFrom('.wishlist a .counter.qty');
        if ((int)$productWishListCountAfter === (int)$productWishListCountBefore + 1) {
            $P->click('.wishlist a');
            $P->waitForElementVisible('a.product-item-link');
            $P->see($productTitle, 'a.product-item-link');
            $P->click('#btn-minicart-close');
        } else {
            throw new Exception("Wishlist qty doesn't change");
        }
    }
}