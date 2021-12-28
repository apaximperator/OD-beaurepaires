<?php

class SearchCest

{
    /**
     * @param GlobalTester $G
     * @param CategoryTester $C
     * @throws Exception
     */
    public function instantSearch(GlobalTester $G, CategoryTester $C)
    {
        $G->amOnPage("/");
        $G->waitPageLoad();
        $G->closePopup();
        $C->openRandomNotEmptyPLP();
        $G->waitPageLoad(10);
        $productsCount = $G->getElementsCountByCssSelector('a[class ="result product-item-link"]');
        $randomProductNumber = rand(1, $productsCount);
        $G->waitForElementClickable("//a[@class='result product-item-link' and @data-position='$randomProductNumber']", 10);
        $productLink = $G->grabAttributeFrom("//a[@class='result product-item-link' and @data-position='$randomProductNumber']", 'href');
        $productName = $G->grabTextFrom("//li[@class='ais-Hits-item item product product-item'][$randomProductNumber]//strong");
        $productLink = str_replace(\Page\Credentials::$URL, '', $productLink);
        $G->instantSearchByText($productName);
        $G->waitPageLoad();
        $G->seeInCurrentUrl($productLink);
        $G->see($productName, "h1.page-title>span");
        $G->instantSearchEmptyResult();
    }

    /**
     * @param GlobalTester $G
     * @param CategoryTester $C
     * @throws Exception
     */
    public function search(GlobalTester $G, CategoryTester $C)
    {
        $G->amOnPage("/");
        $G->waitPageLoad();
        $G->closePopup();
        $C->openRandomNotEmptyPLP();
        $G->waitPageLoad(10);
        $productsCount = $G->getElementsCountByCssSelector('a[class ="result product-item-link"]');
        $randomProductNumber = rand(1, $productsCount);
        $G->waitForElementClickable("//a[@class='result product-item-link' and @data-position='$randomProductNumber']", 10);
        $productName = $G->grabTextFrom("//li[@class='ais-Hits-item item product product-item'][$randomProductNumber]//strong");
        $G->searchByText($productName);
        $G->waitPageLoad();
        $G->see($productName, "//li[@class='ais-Hits-item item product product-item']//strong");
        $G->searchEmptyResult();
    }
}
