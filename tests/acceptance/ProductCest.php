<?php

class ProductCest
{

    /**
     * @param CategoryTester $C
     * @param ProductTester $P
     * @param CartTester $Cart
     * @throws Exception
     */
    public function productPage(CategoryTester $C, ProductTester $P, CartTester $Cart)
    {
        $C->amOnPage('/');
        $C->waitPageLoad(10);
        $C->closePopup(10);
        $C->openRandomNotEmptyPLP();
        $P->openRandomProduct();
        $P->selectRandomOption();
        $P->selectRandomQTY();
        $P->selectRandomStore();
        $P->addProductToCart();
//        $Cart->deleteProductFromCart();
    }

}
