<?php

use Page\Credentials;

class ProductTester extends GlobalTester
{

    /**
     * @throws Exception
     */
    public function openRandomProduct()
    {
        $P = $this;
        $P->waitPageLoad(10);
        $P->wait(1);
        $productsCount = $P->getElementsCountByCssSelector('a[class ="result product-item-link"]');
        $randomProductNumber = rand(1, $productsCount);
        $P->waitForElementClickable("//a[@class='result product-item-link' and @data-position='$randomProductNumber']", 10);
        $productLink = $P->grabAttributeFrom("//a[@class='result product-item-link' and @data-position='$randomProductNumber']", 'href');
        $productLink = str_replace(Credentials::$URL, '', $productLink);
        $P->wait(2);
        $P->waitForElementClickable("//a[@class='result product-item-link' and @data-position='$randomProductNumber']", 10);
        $P->click("//a[@class='result product-item-link' and @data-position='$randomProductNumber']");
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
        $P->wait(2);
        if ($P->tryToDontSeeElement('div[class="field qty"]')) {
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
        $QTYValueNumber = rand(1, $QTYValueCount - 1);
        $QTYValue = $P->grabTextFrom('(//select[contains(@id,"qty")])//option[' . $QTYValueNumber . ']'); //Writing variable with desired option
        if ($QTYValue == 0) {
            $QTYValue++;
        }
        $P->selectOption('(//select[contains(@id,"qty")])', $QTYValue); //Select desired option
        $P->wait(1);
    }

    /**
     * @throws Exception
     */
    public function selectRandomStore()
    {
        $P = $this;
        if ($P->tryToSeeElement("//div[@class='link-trigger-amlocator']/a[@title='Find your store']")) {
            $P->waitForElementClickable("//div[@class='link-trigger-amlocator']/a[@title='Find your store']", 10);
            $P->click("//div[@class='link-trigger-amlocator']/a[@title='Find your store']");
            $P->waitAjaxLoad();
            $storeCount = $this->getElementsCountByCssSelector('a.amlocator-link');
            $storeNumber = rand(1, $storeCount);
            $P->click("//div[@name='leftLocation'][$storeNumber]//a[@class='amlocator-link']");
            $P->wait(5);
            $P->waitForElementClickable("//button[@class='action-cancel action-cancel-new']", 10);
            $P->click("//button[@class='action-cancel action-cancel-new']");
            $P->waitAjaxLoad();
        }
    }


    /**
     * @throws Exception
     */
    public function addProductToCart()
    {
        $P = $this;
        $productCountBefore = $P->executeJS("return jQuery('span.counter-number')[0].innerText");
        $P->waitForElementClickable('#product-addtocart-button', 10);
        $P->click("#product-addtocart-button");
        $P->waitForText('Product Added', 10, '#product-addtocart-button span');
        $P->see('Product Added', '#product-addtocart-button span');
        $P->waitForElementVisible('.booking-panel-tab.active.enabled', 10);
        $P->wait(5);
        $P->waitAjaxLoad();
        $productCountAfter = $P->executeJS("return /\(([^)]+)\)/.exec(document.querySelectorAll('.booking-panel-tab.active.enabled')[0].innerText)[1];");
        if ((int)$productCountAfter == (int)$productCountBefore) {
            throw new Exception("Cart qty doesn't change $productCountAfter !== $productCountBefore");
        }
        $P->clickOnElementByCssSelector('.action-close');
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