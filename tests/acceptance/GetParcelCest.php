<?php

class GetParcelCest
{
    public function canRetrieveAvailablePackage(AcceptanceTester $I)
    {
        $I->sendGet('12345');
        $I->seeHttpHeader('Content-Type');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data.customer');
    }
}
