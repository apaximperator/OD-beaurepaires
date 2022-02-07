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
        $C->closePopup();
        $C->waitPageLoad(10);
        $C->openRandomNotEmptyPLP();
        $C->selectRandomFilter();
        $C->sortBySelect();
        $C->clearFilter();
    }
}
