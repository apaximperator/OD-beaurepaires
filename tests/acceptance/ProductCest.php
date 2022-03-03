<?php

class ProductCest
{

    /**
     * @param CategoryTester $C
     * @param ProductTester $P
     * @param CartTester $Cart
     * @param GlobalTester $G
     * @throws Exception
     */
    public function productPage(CategoryTester $C, ProductTester $P, CartTester $Cart, GlobalTester $G)
    {
        $C->amOnPage('/');
        $C->waitPageLoad(10);
        $C->closePopup(10);
        $G->login();
        $Cart->removeAllProductsFromMinicart();
        $C->openRandomNotEmptyPLP();
        $P->openRandomProduct();
        $C->waitPageLoad();
        $P->selectRandomOption();
        $P->selectRandomQTY();
        $P->selectRandomStore();
        $P->addProductToCart();
        $Cart->removeAllProductsFromMinicart();
    }

}
