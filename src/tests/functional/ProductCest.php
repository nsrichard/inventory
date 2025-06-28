<?php

class ProductCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
    }

    public function getAllProducts(\FunctionalTester $I)
    {
        $I->sendGET('/products');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"status":"success"');
    }

    public function createValidProduct(\FunctionalTester $I)
    {
        $I->sendPOST('/products', [
            'name' => 'Monitor LED',
            'price' => 150.00,
            'stock' => 25,
            'category_id' => 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContains('"status":"created"');
    }


}
