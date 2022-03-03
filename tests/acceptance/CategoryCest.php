<?php

class CategoryCest
{

    /**
     * @param CategoryTester $C
     * @throws Exception
     */
    public function filtersAndSort(CategoryTester $C)
    {
        $C->amOnPage('/');
        $C->waitPageLoad(10);
        $C->closePopup();
        $C->login();
        $C->openRandomNotEmptyPLP();
        $C->selectRandomFilter();
        $C->sortBySelect();
        $C->clearFilter();
    }
}
