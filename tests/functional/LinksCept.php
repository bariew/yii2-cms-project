<?php

use tests\_pages\LoginPage;

$I = new tests\functional\ClickGuy($scenario);
$I->wantTo('ensure that all links work');
$loginPage = LoginPage::openBy($I);
$loginPage->login('pt', 'pt');
$I->clickThemAll('');

