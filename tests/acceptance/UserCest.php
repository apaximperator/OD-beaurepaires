<?php

class UserCest
{
    /**
     * @param GlobalTester $G
     * @throws Exception
     */
    public function userLogin(GlobalTester $G)
    {
        $G->amOnPage('/');
        $G->login();
        $G->logout();
    }

    /**
     * @param GlobalTester $G
     * @throws Exception
     */
    public function userRegister(GlobalTester $G)
    {
        $G->amOnPage('/');
        $user = $G->registration();
        $G->login($user['firstname'], $user['email'], $user['password']);
        $G->logout();
    }

    /**
     * @param GlobalTester $G
     * @throws Exception
     */
    public function editUserData(GlobalTester $G)
    {
        $G->amOnPage('/');
        $G->closePopup();
        $user = $G->registration();
        $G->login($user['firstname'], $user['email'], $user['password']);
        $G->waitForElementClickable('//a[@class= "nav-link show_popup_login"]');
        $G->click('//a[@class= "nav-link show_popup_login"]');
        $G->waitPageLoad();
        $G->waitForElementClickable('//a[@class="action change-password"]');
        $G->click('//a[@class="action change-password"]');
        $G->waitPageLoad();
        $G->waitForElementVisible('//input[@id="firstname"]');
        $newName = $user['firstname'] . 'Test';
        $G->fillField( '//input[@id="firstname"]', $newName);
        $G->waitForElementVisible('//input[@id="lastname"]');
        $newLastname = $user['lastname'] . 'Test';
        $G->fillField( '//input[@id="lastname"]', $newLastname);
        $G->waitForElementVisible('//input[@id="current-password"]');
        $G->fillField( '//input[@id="current-password"]', $user['password']);
        $newPassword = $user['password'] . 'Test';
        $G->waitForElementVisible('//input[@id="password"]');
        $G->fillField( '//input[@id="password"]', $newPassword);
        $G->waitForElementVisible('//input[@id="password-confirmation"]');
        $G->fillField( '//input[@id="password-confirmation"]', $newPassword);
        $G->waitForElementClickable('//button[@class="action save primary"]');
        $G->click('//button[@class="action save primary"]');
        $G->waitPageLoad();
        $G->waitForElementClickable('//a[@class="logo"]');
        $G->click('//a[@class="logo"]');
        $G->waitPageLoad();
        $G->login($newName, $user['email'], $newPassword);
        $G->waitForElementClickable('//a[@class= "nav-link show_popup_login"]');
        $G->click('//a[@class= "nav-link show_popup_login"]');
        $G->waitPageLoad();
        $G->see($newName .' '. $newLastname, '//strong[@class="customer-name"]');
        $G->logout();
    }

}
