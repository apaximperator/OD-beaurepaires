<?php

use Page\Credentials;

class CategoryTester extends GlobalTester
{

    /**
     * @throws Exception
     */
    public function openRandomNotEmptyBrandCategory()
    {
        $C = $this;
        $brandCategoryWithoutProducts = true;
        while ($brandCategoryWithoutProducts) {
            $C->moveMouseOver('//a[@id="ui-id-' . rand(2, 3) . '"]');
            $C->waitForElementClickable('li.hover div.brands-logo a');
            $C->wait(2);
            $BrandCategoryCount = $C->getElementsCountByCssSelector('li.hover div.brands-logo a');
            $BrandCategoryNumber = rand(1, $BrandCategoryCount + 1);
            $BrandLink = $C->grabAttributeFrom('//*[contains(@class, "hover")]//div[@class="brands-item"][' . $BrandCategoryNumber . ']//a', 'href');
            $BrandLink = str_replace(Credentials::$URL, '', $BrandLink);
            $C->click('//*[contains(@class, "hover")]//div[@class="brands-item"][' . $BrandCategoryNumber . ']//a');
            $C->waitPageLoad();
            $C->seeInCurrentUrl($BrandLink);
            try {
                $C->seeElement('//div[@class="product actions product-item-actions"]/div/a');
                $brandCategoryWithoutProducts = false;
            } catch (Exception $e) {
                $brandCategoryWithoutProducts = true;
            }
        }
    }

    /**
     * @throws Exception
     */
    public function openRandomNotEmptyCLP()
    {
        $C = $this;
        $C->connectJq();
        $categoryWithoutProducts = true;
        while ($categoryWithoutProducts) {
            $C->click('//a[@id="ui-id-' . rand(2, 3) . '"]');
            $C->waitPageLoad();
            try {
                $C->seeElement('//div[@class="product actions product-item-actions"]/div/a');
                $categoryWithoutProducts = false;
            } catch (Exception $e) {
                $categoryWithoutProducts = true;
            }
        }
    }

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
               if ($nav === 2){ //fix recommended tab
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
        $C->connectJq();
        $dropdownFiltersCount = $C->getElementsCountByCssSelector(".filter-options-title");
        $randomDropdownFilter = rand(0, $dropdownFiltersCount - 1);
        $C->executeJS("document.querySelectorAll(\".filter-options-title\")[$randomDropdownFilter].click()");
        $C->waitAjaxLoad();
        $filterName = $C->executeJS("return document.querySelector(\"div[aria-selected='true']\").innerText;");
        if ($filterName == 'COLOR') {
            $C->waitForElementVisible('div[aria-hidden = "false"] form div.item', 10);
            $filtersCount = $C->getElementsCountByCssSelector('div[aria-hidden = "false"] form div.item');
            $randomFilterNumber = rand(1, $filtersCount);
            $C->waitForElementClickable("div[aria-hidden = false] form div.item:nth-of-type($randomFilterNumber) a", 10);
            $C->executeJS("document.querySelector('div[aria-hidden = false] form div.item:nth-of-type($randomFilterNumber) a').click()");
        } else {
            $C->waitForElementVisible('div[aria-hidden = "false"] li.item', 10);
            $filtersCount = $C->getElementsCountByCssSelector('div[aria-hidden = "false"] li.item');
            $randomFilterNumber = rand(1, $filtersCount);
            $C->waitForElementClickable("div[aria-hidden = false] li.item:nth-of-type($randomFilterNumber)", 10);
            $C->executeJS("document.querySelector('div[aria-hidden = false] li.item:nth-of-type($randomFilterNumber)').click()");
        }
        $C->waitAjaxLoad();
        $C->waitForElementVisible("a.action.clear.filter-clear", 10);
    }

    /**
     * @throws Exception
     */
    public function clearFilter()
    {
        $C = $this;
        $C->executeJS('window.scrollTo(0,0);');
        $C->waitForElementClickable("a.action.clear.filter-clear", 10);
        $C->click("a.action.clear.filter-clear");
        $C->waitForElementNotVisible("a.action.clear.filter-clear", 10);
    }

}