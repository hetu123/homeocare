<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('Homeocare');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');
    }
}