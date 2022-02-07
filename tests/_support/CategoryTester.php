<?php

use Page\Credentials;

class CategoryTester extends GlobalTester
{

    /**
     * @throws Exception
     */
    public function openRandomNotEmptyPLP()
    {
        $C = $this;
        $C->connectJq();
        $categoryWithoutProducts = true;
        while ($categoryWithoutProducts) {
            $nav = rand(2, 4);
            $C->moveMouseOver('//a[@id="ui-id-' . $nav . '"]');
            $C->wait(2);
            if ($nav === 4) {
                $C->waitForElementClickable('//a[@id="ui-id-4"]');
                $C->click('//a[@id="ui-id-4"]');
            } else {
                $C->waitForElementClickable('//*[contains(@class, "hover")]//div[@class="bottom-links"]//a[contains(text(), "All")]');
                $C->click('//*[contains(@class, "hover")]//div[@class="bottom-links"]//a[contains(text(), "All")]');
                $C->waitPageLoad();
                if ($nav === 2) { //fix recommended tab
                    $C->click('//div[@class="recommended-tab all-options"]');
                }
            }
            $C->waitPageLoad();
            $C->wait(2);
            try {
                $C->seeElement("//a[@class='result product-item-link' and @data-position='1']");
                $categoryWithoutProducts = false;
            } catch (Exception $e) {
                $categoryWithoutProducts = true;
            }
        }
    }

    /**
     * @throws Exception
     */
    public function sortBySelect()
    {
        $C = $this;
        $C->connectJq();
        $C->waitForElementVisible('//select[@class="ais-SortBy-select"]', 10);
        $sortCount = $C->getElementsCountByCssSelector('select.ais-SortBy-select>option');
        for ($optionByIndex = 1; $optionByIndex < $sortCount; $optionByIndex++) {
            $sortByOption = $C->grabTextFrom('//select[@class="ais-SortBy-select"]/option[' . $optionByIndex . ']');
            $C->selectOption('//select[@class="ais-SortBy-select"]', $sortByOption);
            $C->waitPageLoad();
            $C->wait(1);
            $C->seeOptionIsSelected('//select[@class="ais-SortBy-select"]', $sortByOption);
        }
    }

    /**
     * @throws Exception
     */
    public function selectRandomFilter()
    {
        $C = $this;
        $C->waitPageLoad();
        $C->clickOnElementByCssSelector('div.is-widget-container-brand div.name');
        $C->waitAjaxLoad();
        $C->waitForElementVisible('div.is-widget-container-brand label', 10);
        $filtersCount = $C->getElementsCountByCssSelector('div.is-widget-container-brand label');
        $randomFilterNumber = rand(1, $filtersCount);
        $C->waitForElementClickable("div.is-widget-container-brand .ais-RefinementList-item:nth-of-type($randomFilterNumber) label", 10);
        $C->clickOnElementByCssSelector("div.is-widget-container-brand .ais-RefinementList-item:nth-of-type($randomFilterNumber) label");
        $C->waitAjaxLoad();
        $C->waitForElementVisible("//button[@class='ais-ClearRefinements-button action primary']", 10);
        $value = $C->grabAttributeFrom("//label[@class='ais-RefinementList-label checked']/input", 'value');
        $valueNew = $C->grabAttributeFrom("//li[@class='ais-Hits-item item product product-item'][1]//div[@class ='result-sub-content']/img", 'title');
        if($value != $valueNew){
            throw new Exception("Cart qty doesn't change $value !== $valueNew");
        }
    }

    /**
     * @throws Exception
     */
    public function clearFilter()
    {
        $C = $this;
        $C->executeJS('window.scrollTo(0,0);');
        $C->waitForElementClickable("//button[@class='ais-ClearRefinements-button action primary']", 10);
        $C->click("//button[@class='ais-ClearRefinements-button action primary']");
        $C->waitForElementNotVisible("//button[@class='ais-ClearRefinements-button action primary']", 10);
    }

}