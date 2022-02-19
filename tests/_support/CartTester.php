<?php

class CartTester extends GlobalTester
{

    /**
     * @throws Exception
     */
    public function changeProductQtyOnMiniCart()
    {
        $Cart = $this;
        $Cart->waitPageLoad();
        $productCountBefore = $Cart->executeJS("return jQuery('span.counter-number')[0].innerText");
        $Cart->waitForElementClickable("//button[@class='action showcart primary blue']", 10);
        $Cart->click("//button[@class='action showcart primary blue']");
        $Cart->waitForElementVisible("//strong[@class='product-item-name']/a", 10);
        $cartProductQTY = $Cart->grabAttributeFrom('//select[@class="item-qty cart-item-qty minicart-product__qty-input"]', 'data-item-qty');
        $QTYValueCount = $Cart->getElementsCountByCssSelector('select#qty>option');
        $QTYValueNumber = rand(1, $QTYValueCount - 1);
        $Cart->selectOption('//select[@class="item-qty cart-item-qty minicart-product__qty-input"]', $QTYValueNumber);
        $Cart->waitForElementClickable('//button[@class="update-cart-item minicart-product__update-btn"]', 10);
        $Cart->click('//button[@class="update-cart-item minicart-product__update-btn"]');
        $Cart->wait(3);
        $cartProductQTYNew = $Cart->grabAttributeFrom('//select[@class="item-qty cart-item-qty minicart-product__qty-input"]', 'data-item-qty');
        $Cart->clickOnElementByCssSelector('.action-close');
        $Cart->wait(3);
        $cartCountAfter = $Cart->executeJS("return jQuery('span.counter-number')[0].innerText");
        if ((int)($cartCountAfter) !== (int)($productCountBefore - ($cartProductQTY - $cartProductQTYNew))) {
            throw new Exception("QTY doesn't change");
        }
    }

    /**
     * @throws Exception
     */
    public function deleteProductFromMiniCart()
    {
        $Cart = $this;
        $Cart->waitPageLoad();
        $cartCountBefore = $Cart->executeJS("return jQuery('span.counter-number')[0].innerText");
        $Cart->waitForElementClickable("//button[@class='action showcart primary blue']", 10);
        $Cart->click("//button[@class='action showcart primary blue']");
        try {
            $Cart->see("Shop and add tyres, wheels, or a battery to your fitment booking", ".minicart-empty__text");
        } catch (Exception $e) {
            $Cart->waitForElementVisible("//strong[@class='product-item-name']/a", 10);
            $Cart->waitForElementClickable('//button[@class="action delete minicart-product__remove-btn"]', 10);
            $Cart->click('//button[@class="action delete minicart-product__remove-btn"]');
            $Cart->waitForElementClickable('//button[@class="action  primary action-accept"]', 10);
            $Cart->click('//button[@class="action  primary action-accept"]');
            $Cart->waitAjaxLoad();
            $Cart->waitForText("Shop and add tyres, wheels, or a battery to your fitment booking", 10, ".minicart-empty__text");
            $Cart->clickOnElementByCssSelector('.action-close');
            $Cart->wait(3);
            $cartCountAfter = $Cart->executeJS("return jQuery('span.counter-number')[0].innerText");
            if ((int)$cartCountBefore == (int)$cartCountAfter) {
                throw new Exception("QTY not correct. $cartCountBefore == $cartCountAfter");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function removeAllProductsFromMinicart()  //Cycle with 'empty cart' check for remove all products from minicart
    {
        $Cart = $this;
        $Cart->waitForElementClickable("//button[@class='action showcart primary blue']", 10);
        $Cart->click("//button[@class='action showcart primary blue']");
        $Cart->executeJS("document.querySelector('[class=\"booking-panel-tab__icon booking-panel-tab__icon--items\"]').click()");
        $cartIsNotEmpty = true; //Creating a variable for an empty cart
        while ($cartIsNotEmpty) { //Start cycle for clear cart
            try {
                $Cart->dontSee('Shop and add tyres, wheels, or a battery to your fitment booking', ".minicart-empty__text"); //Check that there is no 'YOUR CART IS EMPTY' text
                $Cart->waitForElementClickable('(//button[@class="action delete minicart-product__remove-btn"])[last()]', 10);
                $Cart->click('(//button[@class="action delete minicart-product__remove-btn"])[last()]');
                $Cart->waitForElementClickable('//button[@class="action  primary action-accept"]', 10);
                $Cart->click('//button[@class="action  primary action-accept"]');
                $Cart->waitAjaxLoad();
                $cartIsNotEmpty = true; //Cart is not empty - false
            } catch (Exception $e) {
                $cartIsNotEmpty = false; //Cart is not empty - true
            }
        }
        $Cart->see('Shop and add tyres, wheels, or a battery to your fitment booking', ".minicart-empty__text"); //Check that there is no 'YOUR CART IS EMPTY' text
        $Cart->clickOnElementByCssSelector('.action-close');
    }

    /**
     * @throws Exception
     */
    public function addCouponToMiniCart() //TODO достать валидный купон и дописать тест
    {
        $Cart = $this;
        $Cart->waitPageLoad();
        $Cart->click('a.showcart');
        $Cart->waitForElementVisible("#block-discount-heading", 10);
        $cartOrderTotalBefore = $Cart->grabTextFrom("#minicart-tax-order-total .price");
        $Cart->executeJS("document.querySelectorAll('#discount-minicart-content')[0].style.display = 'block'");
        $Cart->fillField('#discount-code-fake', \Page\Credentials::$COUPON);
        $Cart->click(".action.action-apply");
        $cartOrderTotalAfter = $Cart->grabTextFrom("#minicart-tax-order-total .price");
        if ((int)$cartOrderTotalBefore === (int)$cartOrderTotalAfter) {
            throw new Exception("Coupon not apply");
        }
    }
}