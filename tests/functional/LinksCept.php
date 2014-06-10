<?php
require_once __DIR__ .'/ClickGuy.php';
$time = time();
$I = new ClickGuy($scenario);
$I->amOnPage($I->getUrl('index/logout'));
$I->amOnPage($I->getUrl('index/login'));
$I->see("Login");
$I->wantTo('ensure that all links work');
$I->fillField('input[name="LoginForm[username]"]', 'Alena');
$I->fillField('input[name="LoginForm[password]"]', 'password');
$I->click('login-button');
$I->amOnPage($I->getUrl('/'));

$I->clickAllLinks();


//echo "\n\n\nOK - " . count($I->visited) . " links in ". (time()-$time) ."  sec.\n";
//print_r($I->visited);exit;