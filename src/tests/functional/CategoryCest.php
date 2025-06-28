<?php

class CategoryCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
    }

    public function verListadoDeCategorias(\FunctionalTester $I)
    {
        $I->sendGET('/categories');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseContains('"status":"success"');
    }

    public function crearCategoriaValida(\FunctionalTester $I)
    {
        $I->sendPOST('/categories', [
            'name' => 'Tecnología',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContains('"status":"created"');
    }
}
