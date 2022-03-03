<?php

class CheckoutCest
{
    /**
     * @param GlobalTester $G
     * @param CartTester $Cart
     * @param CategoryTester $C
     * @param ProductTester $P
     * @param CheckoutTester $Ch
     * @throws Exception
     */
    public function zipPayment(GlobalTester $G, CartTester $Cart, CategoryTester $C, ProductTester $P, CheckoutTester $Ch)
    {
        $G->amOnPage('/');
        $G->waitPageLoad();
        $G->closePopup();
        $G->login();
        $Cart->removeAllProductsFromMinicart();
        $C->openRandomNotEmptyPLP();
        $P->openRandomProduct();
        $C->waitPageLoad();
        $P->selectRandomOption();
        $P->selectRandomQTY();
        $P->selectRandomStore();
        $P->addProductToCart();
        $Ch->goToCheckout();
        $Ch->paymentMethodByArgument('zipmoneypayment');
    }

    /**
     * @param CartTester $Cart
     * @param CategoryTester $C
     * @param GlobalTester $G
     * @param ProductTester $P
     * @param CheckoutTester $Ch
     * @throws Exception
     */
    public function openPayPayment(CartTester $Cart, CategoryTester $C, GlobalTester $G, ProductTester $P, CheckoutTester $Ch)
    {
        $G->amOnPage('/');
        $G->waitPageLoad();
        $G->closePopup();
        $G->login();
        $Cart->removeAllProductsFromMinicart();
        $C->openRandomNotEmptyPLP();
        $P->openRandomProduct();
        $C->waitPageLoad();
        $P->selectRandomOption();
        $P->selectRandomQTY();
        $P->selectRandomStore();
        $P->addProductToCart();
        $Ch->goToCheckout();
        $Ch->paymentMethodByArgument('openpay');
    }

    /**
     * @param CartTester $Cart
     * @param CategoryTester $C
     * @param GlobalTester $G
     * @param ProductTester $P
     * @param CheckoutTester $Ch
     * @throws Exception
     */
    public function afterPayPayment(CartTester $Cart, CategoryTester $C, GlobalTester $G, ProductTester $P, CheckoutTester $Ch)
    {
        $G->amOnPage('/');
        $G->waitPageLoad();
        $G->closePopup();
        $G->login();
        $Cart->removeAllProductsFromMinicart();
        $C->openRandomNotEmptyPLP();
        $P->openRandomProduct();
        $C->waitPageLoad();
        $P->selectRandomOption();
        $P->selectRandomQTY();
        $P->selectRandomStore();
        $P->addProductToCart();
        $Ch->goToCheckout();
        $Ch->paymentMethodByArgument('afterpaypayovertime');
    }

    /**
     * @param CartTester $Cart
     * @param CategoryTester $C
     * @param GlobalTester $G
     * @param ProductTester $P
     * @param CheckoutTester $Ch
     * @throws Exception
     */
    public function creditCartPayment(CartTester $Cart, CategoryTester $C, GlobalTester $G, ProductTester $P, CheckoutTester $Ch)
    {
        $G->amOnPage('/');
        $G->waitPageLoad();
        $G->closePopup();
        $G->login();
        $Cart->removeAllProductsFromMinicart();
        $C->openRandomNotEmptyPLP();
        $P->openRandomProduct();
        $C->waitPageLoad();
        $P->selectRandomOption();
        $P->selectRandomQTY();
        $P->selectRandomStore();
        $P->addProductToCart();
        $Ch->goToCheckout();
        $Ch->paymentMethodByArgument('braintree');
    }

    /**
     * @param CartTester $Cart
     * @param CategoryTester $C
     * @param GlobalTester $G
     * @param ProductTester $P
     * @param CheckoutTester $Ch
     * @throws Exception
     */
    public function payPalPayment(CartTester $Cart, CategoryTester $C, GlobalTester $G, ProductTester $P, CheckoutTester $Ch)
    {
        $G->amOnPage('/');
        $G->waitPageLoad();
        $G->closePopup();
        $G->login();
        $Cart->removeAllProductsFromMinicart();
        $C->openRandomNotEmptyPLP();
        $P->openRandomProduct();
        $C->waitPageLoad();
        $P->selectRandomOption();
        $P->selectRandomQTY();
        $P->selectRandomStore();
        $P->addProductToCart();
        $Ch->goToCheckout();
        $Ch->paymentMethodByArgument('paypal_express');
    }

}
