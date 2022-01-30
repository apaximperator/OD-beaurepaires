<?php

class ProductCest
{

    /**
     * @param CategoryTester $C
     * @param ProductTester $P
     * @param CartTester $Cart
     * @throws Exception
     */
    public function productPage(CategoryTester $C, ProductTester $P, CartTester $Cart, GlobalTester $G)
    {
//        $C->amOnPage('/');
        $C->amOnPage('/tyres');
        $C->waitPageLoad(10);
//        $C->closePopup(10);
        $G->login();
//        $C->openRandomNotEmptyPLP();
        $C->amOnPage('/tyres');
        $P->openRandomProduct();
//        $C->waitPageLoad();
//        $P->selectRandomOption();
//        $P->selectRandomQTY();
//        $P->selectRandomStore();
//        $P->addProductToCart();
//        $Cart->changeProductQtyOnMiniCart();
        $Cart->deleteProductFromMiniCart();
    }

}
