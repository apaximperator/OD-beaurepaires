<?php

use Facebook\WebDriver\WebDriverKeys;
use Faker\Factory;
use Page\Credentials;

class GlobalTester extends AcceptanceTester
{

    /**
     * @param string $firstname
     * @param string $email
     * @param string $password
     * @throws Exception
     */
    public function login(string $firstname = "", string $email = "", string $password = "")
    {
        $G = $this;
        $G->connectJq();
        if ($email == "") {
            $email = Credentials::$EMAIL;
        }
        if ($password == "") {
            $password = Credentials::$PASSWORD;
        }
        if ($firstname == "") {
            $firstname = Credentials::$FIRSTNAME;
        }
        $G->waitPageLoad();
        try {
            $G->waitForText("My Account", 10, 'a[class="nav-link show_popup_login"]');
        } catch (Exception $e) {
            $G->waitForElementClickable('a[class="nav-link show_popup_login"]', 30);
            $G->click('a[class="nav-link show_popup_login"]');
            $G->wait(5);
            $G->waitForElementVisible('//div[@class = "prpl-login-title" and contains(text(), "Sign in to your account")]');
            $G->fillField('//input[@id = "prpl-email"]', $email);
            $G->fillField('//input[@id = "prpl-pass"]', $password);
            $G->click('//button[@class = "action action-login primary"]');
            $G->waitAjaxLoad();
            $G->waitForText("My Account", 10, 'a[class="nav-link show_popup_login"]');
        }
    }

    /**
     * @throws Exception
     */
    public function logout()
    {
        $G = $this;
        $G->connectJq();
        $G->waitPageLoad();
        try {
            $G->waitForText("Sing In", 10, 'a[class="nav-link show_popup_login"]');
        } catch (Exception $e) {
            $G->waitForText("My Account", 10, 'a[class="nav-link show_popup_login"]');
            $G->waitForElementClickable('a[class="nav-link show_popup_login"]');
            $G->click('a[class="nav-link show_popup_login"]');
            $G->waitPageLoad();
            $G->waitForElementClickable('//li[@class="nav item"]/a[contains(text(), "Sign Out")]');
            $G->click('//li[@class="nav item"]/a[contains(text(), "Sign Out")]');
            $G->waitPageLoad();
            $G->waitForElementVisible('//h1/span[contains(text(), "You are signed out")]', 30);
            $G->wait(5);
            $G->waitPageLoad();
            $G->seeCurrentUrlEquals('/');
        }
    }

    /**
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @return array(str, str, str)
     * @throws Exception
     */
    public function registration(string $firstname = '', string $lastname = '', string $email = '', string $password = ''): array
    {
        $G = $this;
        if ($email == "") {
            $email = Factory::create()->safeEmail;
        }
        if ($password == "") {
            $password = Credentials::$PASSWORD;
        }
        if ($firstname == "") {
            $firstname = Credentials::$FIRSTNAME;
        }
        if ($lastname == "") {
            $lastname = Credentials::$LASTNAME;
        }
        $G->connectJq();
        $G->waitPageLoad();
        $G->waitForText("Sign In", 10, 'a[class="nav-link show_popup_login"]');
        $G->waitForElementClickable('a[class="nav-link show_popup_login"]', 30);
        $G->click('a[class="nav-link show_popup_login"]');
        $G->wait(3);
        $G->waitForElementVisible('//div[@class = "prpl-login-title" and contains(text(), "Sign in to your account")]');
        $G->waitForElementClickable('//span[contains(text(), "Create an account")]/ancestor::a');
        $G->click('//span[contains(text(), "Create an account")]/ancestor::a');
        $G->waitForElementVisible('//div[@class = "prpl-login-title" and contains(text(), "Create New Customer Account")]');
        $G->fillField('//input[@name = "firstname"]', $firstname);
        $G->fillField('//input[@name = "lastname"]', $lastname);
        $G->fillField('//input[@name = "email"]', $email);
        $G->fillField('//input[@name = "telephone"]', Credentials::$PHONE);
        $G->fillField('//input[@name = "password" and @placeholder = "Password" and not(@id="prpl-pass")]', $password);
        $G->click('//button[@class = "action submit primary"]');
        $G->waitAjaxLoad();
        $G->waitForText("My Account", 10, 'a[class="nav-link show_popup_login"]');
        return ['firstname' => $firstname, 'email' => $email, 'password' => $password];
    }

    /**
     * @param int $time
     * @throws Exception
     */
    public function closePopup(int $time = 30)
    {
        $G = $this;
        $G->connectJq();
        $G->waitForElementVisible("#webChannel .title", $time);
        $G->click("div[data-wps-popup-close]");
        $G->waitForElementNotVisible("#webChannel .title", 5);
    }


    /**
     * @param string $searchString
     * @throws Exception
     */
    public function instantSearchByText(string $searchString = "test")
    {
        $G = $this;
        $G->connectJq();
        $G->waitForElementVisible("#search");
        $G->click("#search");
        $G->fillField("#search", $searchString);
        $G->waitForElementClickable("#klevuSearchSuggest ul li a", 10);
        $G->click("#klevuSearchSuggest ul li a");
        $G->amOnPage("/");
    }

    /**
     * @param string $searchString
     * @throws Exception
     */
    public function searchByText(string $searchString = "test")
    {
        $G = $this;
        $G->connectJq();
        $G->waitForElementVisible("#search");
        $G->click("#search");
        $G->fillField("#search", $searchString);
        $G->pressKey('#search', WebDriverKeys::ENTER);
        $G->waitForText("Search results for: '$searchString'", 10, "span.base");
        $G->see("Search results for: '$searchString'", "span.base");
        $G->amOnPage("/");
    }

    /**
     * @throws Exception
     */
    public function instantSearchEmptyResult()
    {
        $G = $this;
        $G->connectJq();
        $G->waitForElementVisible("#search");
        $G->click("#search");
        $G->fillField("#search", "qwerreqwerqwer");
        $G->waitForText("Please try another search term...", 30, ".klevuNoResults-message");
        $G->see('Please try another search term...', ".klevuNoResults-message");
        $G->amOnPage("/");
    }

    /**
     * @throws Exception
     */
    public function searchEmptyResult()
    {
        $G = $this;
        $G->connectJq();
        $G->waitForElementVisible("#search");
        $G->click("#search");
        $G->fillField("#search", "qwerreqwerqwer");
        $G->pressKey('#search', WebDriverKeys::ENTER);
        $G->waitForText("Please try another search term...", 30, ".kuNoResults-lp-message");
        $G->see('Please try another search term...', ".kuNoResults-lp-message");
        $G->amOnPage("/");
    }

    /**
     * @throws Exception
     */
    public function clearAdditionalAddresses()
    {
        $G = $this;
        $G->amOnPage('/');
        $G->waitPageLoad();
        $G->waitForElementClickable('a[class="action link-account customer-account-menu"]');
        $G->click('a[class="action link-account customer-account-menu"]');
        $G->waitForElementClickable("//ul[@id='customer-account-menu']/li/a[contains(.,'My Addresses')]");
        $G->click("//ul[@id='customer-account-menu']/li/a[contains(.,'My Addresses')]");
        $G->waitPageLoad();
        $G->waitForElementClickable('button[class="action secondary add"]');
        $additionalAddressesEmpty = true;
        while ($additionalAddressesEmpty) {
            try {
                $G->seeElement('table[id="additional-addresses-table"]');
                $G->waitForElementClickable("(//a[@class='action delete icon icon-trash'])[last()]");
                $G->click("(//a[@class='action delete icon icon-trash'])[last()]");
                $G->waitForElementClickable(".action-primary.action-accept", 10);
                $G->click(".action-primary.action-accept");
                $G->waitAjaxLoad();
                $additionalAddressesEmpty = true;
            } catch (Exception $e) {
                $additionalAddressesEmpty = false;
            }
        }
    }

    /**
     * @throws Exception
     */
    public function editAdditionalAddresses()
    {
        $G = $this;
        $G->amOnPage('/');
        $G->waitPageLoad();
        $G->waitForElementClickable('a[class="action link-account customer-account-menu"]');
        $G->click('a[class="action link-account customer-account-menu"]');
        $G->waitForElementClickable("//ul[@id='customer-account-menu']/li/a[contains(.,'My Addresses')]");
        $G->click("//ul[@id='customer-account-menu']/li/a[contains(.,'My Addresses')]");
        $G->waitPageLoad();
        $G->waitForElementClickable('td a[class="action edit"]');
        $oldPhone = $G->grabTextFrom('td[class="col phone"]');
        $G->click('td a[class="action edit"]');
        $G->waitPageLoad();
        $G->waitForElementClickable('button[class="action save primary"]');
        $G->click("//input[@id='street_1']"); //Click to shipping address field
        $G->wait(2);
        $G->fillField("//input[@id='street_1']", '1000'); //Add shipping index to the field
        $G->wait(5);
        $addressList = rand(1, 5);
        $G->click("//ul/li[@id][$addressList]"); //Choose random shipping address
        $G->wait(2);
        $G->waitPageLoad();
        $G->click("//input[@id='telephone']"); //Click to  phone number field
        $G->wait(2);
        $G->fillField("//input[@id='telephone']", $oldPhone+1); //Add phone number
        $G->waitForElementClickable('button[class="action save primary"]');
        $G->click('button[class="action save primary"]');
        $G->waitPageLoad();
        $G->waitForElementVisible('table[id="additional-addresses-table"]');
        $newPhone = $G->grabTextFrom('td[class="col phone"]');
        If($oldPhone == $newPhone){
            throw new Exception('Edit doesn\'t work correct');
        }

    }

    /**
     * @throws Exception
     */
    public function addAdditionalAddresses()
    {
        $G = $this;
        $G->amOnPage('/');
        $G->waitPageLoad();
        $G->waitForElementClickable('a[class="action link-account customer-account-menu"]');
        $G->click('a[class="action link-account customer-account-menu"]');
        $G->waitForElementClickable("//ul[@id='customer-account-menu']/li/a[contains(.,'My Addresses')]");
        $G->click("//ul[@id='customer-account-menu']/li/a[contains(.,'My Addresses')]");
        $G->waitPageLoad();
        $G->waitForElementClickable('button[class="action secondary add"]');
        $G->click('button[class="action secondary add"]');
        $G->waitPageLoad();
        $G->waitForElementClickable('button[class="action save primary"]');
        $G->click("//input[@id='street_1']"); //Click to shipping address field
        $G->wait(2);
        $G->fillField("//input[@id='street_1']", '1000'); //Add shipping index to the field
        $G->wait(5);
        $addressList = rand(1, 5);
        $G->click("//ul/li[@id][$addressList]"); //Choose random shipping address
        $G->wait(2);
        $G->waitPageLoad();
        $G->click("//input[@id='telephone']"); //Click to  phone number field
        $G->wait(2);
        $G->fillField("//input[@id='telephone']", '3222333'); //Add phone number
        $G->waitForElementClickable('button[class="action save primary"]');
        $G->click('button[class="action save primary"]');
        $G->waitPageLoad();
        $G->waitForElementVisible('table[id="additional-addresses-table"]');
    }
}