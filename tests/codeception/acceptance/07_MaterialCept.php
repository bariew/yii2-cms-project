<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that Material create works');

// CUSTOMER
$I->customerLogin();
$I->go(['/material/item/create']);
// wrong data
$I->attachFile('#item-file', 'mmc.pdf'); // small dpi
$I->testForm('#item-form', 'Item', [], [
    'file' => 123,
    'type' => 123,
    'owner_id' => 3, // its another customer
    'valid_from' => '28/12/2015', // invalid format
    'valid_to' => '2015-12-28', // valid_to can not be less than valid_from
]);
// correct data
$I->attachFile('#item-file', 'material.jpg');
$I->testForm('#item-form', 'Item', [
    'file' => 'material.jpg',
    'type' => 0,
    'owner_id' => 2, // its partner company
    'description' => 'asdasd',
    'valid_from' => date('Y-m-d'),
    'valid_to' => date('Y-m-d'),
]);
$I->seeElement('.alert-success');

// CUSTOMER
$I->partnerLogin();
$I->go(['/material/item/create']);
// wrong data
$I->attachFile('#item-file', 'mmc.pdf'); // small dpi
$I->testForm('#item-form', 'Item', [
    'owner_id' => 123, // its not saved
], [
    'file' => 123,
    'type' => 123,
    'valid_from' => '28/12/2015', // invalid format
    'valid_to' => '2015-12-28', // valid_to can not be less than valid_from
]);
// correct data
$I->attachFile('#item-file', 'material.jpg');
$I->testForm('#item-form', 'Item', [
    'file' => 'material.jpg',
    'type' => 0,
    'description' => 'asdasd',
    'valid_from' => date('Y-m-d'),
    'valid_to' => date('Y-m-d'),
]);
$I->seeElement('.alert-success');

// PARTNER
// no upload role
$partner = \bariew\yii2Tools\tests\FixtureManager::get('user_user', 'test_partner1');
$I->login($partner->username, 'admin');
$I->go(['/material/item/create']);
$I->seeElement('.alert-danger');
// correct data
$partner = \bariew\yii2Tools\tests\FixtureManager::get('user_user', 'example_partner1');
$I->login($partner->username, 'admin');
$I->go(['/material/item/create']);
$I->dontSeeElement('.alert-danger');
// wrong data
$I->attachFile('#item-file', 'mmc.pdf'); // small dpi
$I->testForm('#item-form', 'Item', [
    'owner_id' => 123, // its not saved
], [
    'file' => 123,
    'type' => 123,
    'valid_from' => '28/12/2015', // invalid format
    'valid_to' => '2015-12-28', // valid_to can not be less than valid_from
]);
// correct data
$I->attachFile('#item-file', 'material.jpg');
$I->testForm('#item-form', 'Item', [
    'file' => 'material.jpg',
    'type' => 0,
    'description' => 'asdasd',
    'valid_from' => date('Y-m-d'),
    'valid_to' => date('Y-m-d'),
]);
$I->seeElement('.alert-success');