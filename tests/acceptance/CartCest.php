<?php

class CartCest
{

    /**
     * @param CategoryTester $C
     * @param ProductTester $P
     * @param CartTester $Cart
     * @throws Exception
     */
    public function miniCart(CategoryTester $C, ProductTester $P, CartTester $Cart)
    {
        $C->amOnPage('/');
        $C->closePopup();
        $C->login();
        $Cart->removeAllProductsFromMinicart();
        $C->openRandomNotEmptyPLP();
        $P->openRandomProduct();
        $C->waitPageLoad();
        $P->selectRandomOption();
        $P->selectRandomQTY();
        $P->selectRandomStore();
        $P->addProductToCart();
        $Cart->changeProductQtyOnMiniCart();
        $Cart->removeAllProductsFromMinicart();
    }

}
