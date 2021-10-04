<?php

class TestCurrenciesCest
{
    public function testTryToGetWithoutCSRFToken(ApiTester $I)
    {
        $I->sendAjaxPostRequest('/convert', [
            'baseCurrency' => 'EUR',
            'targetCurrency' => 'USD',
            'value' => '1.00',
        ]);
        $I->canSeeResponseCodeIs('419');
    }

    public function testTryToGetCorrectResponceWithCSRFToken(ApiTester $I)
    {
        $I->amOnUrl('http://nginx');
        $token = $I->grabAttributeFrom('#_token', 'value');
        $I->sendAjaxPostRequest('/convert', [
            'baseCurrency' => 'EUR',
            'targetCurrency' => 'USD',
            'value' => '1.00',
            '_token' => $token
        ]);
        $I->canSeeResponseCodeIs('200');
    }

    public function testTryToGetSameCurrency(ApiTester $I)
    {
        $I->amOnUrl('http://nginx');
        $token = $I->grabAttributeFrom('#_token', 'value');
        $I->sendAjaxPostRequest('/convert', [
            'baseCurrency' => 'EUR',
            'targetCurrency' => 'EUR',
            'value' => '1.00',
            '_token' => $token
        ]);
        $I->canSeeResponseCodeIs('422');
    }

    public function testTryToGetUnexpectedCurrency(ApiTester $I)
    {
        $I->amOnUrl('http://nginx');
        $token = $I->grabAttributeFrom('#_token', 'value');
        $I->sendAjaxPostRequest('/convert', [
            'baseCurrency' => 'NOTEXISTS',
            'targetCurrency' => 'EUR',
            'value' => '1.00',
            '_token' => $token
        ]);
        $I->canSeeResponseCodeIs('422');
    }
}
