<?php

class CategoryCest
{

    /**
     * @param CategoryTester $C
     * @throws Exception
     */
    public function filters(CategoryTester $C)
    {
        $C->amOnPage('/');
        $C->waitPageLoad(10);
        $C->openRandomNotEmptyCLP();
        $C->selectRandomFilter();
        $C->clearFilter();
        $C->openRandomNotEmptyPLP();
        $C->selectRandomFilter();
        $C->clearFilter();
        $C->openRandomNotEmptyBrandCategory();
        $C->selectRandomFilter();
        $C->clearFilter();
    }

    /**
     * @param CategoryTester $C
     * @throws Exception
     */
    public function sortByOnPLP(CategoryTester $C)
    {
        $C->amOnPage('/');
        $C->waitPageLoad(10);
        $C->openRandomNotEmptyPLP();
        $C->sortBySelect();
    }

    /**
     * @param CategoryTester $C
     * @throws Exception
     */
    public function sortByOnBrand(CategoryTester $C)
    {
        $C->amOnPage('/');
        $C->waitPageLoad(10);
        $C->openRandomNotEmptyBrandCategory();
        $C->sortBySelect();
    }
}
