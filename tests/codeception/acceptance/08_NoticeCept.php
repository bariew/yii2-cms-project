<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that Notice create works');

// ADMIN
$I->login();
$I->go(['/notice/item/create']);
// wrong data
$I->testForm('#notice-form', 'Item', [], [
    'owner_id' => 123,
    'users[]' => 123,
    'partners[]' => 123,
    'message' => '',
    'date_from' => '28/12/2015', // invalid format
    'date_to' => '2015-12-28', // can not be less than date_from
]);
// correct data
$I->testForm('#notice-form', 'Item', [
    'owner_id' => 1,
    'partners[]' => 2,
    'users[]' => 3, // its my partner
    'message' => 'test message',
    'date_from' => '2015-10-10',
    'date_to' => '2015-10-10',
]);
$I->seeElement('.alert-success');

// CUSTOMER
$I->customerLogin();
$I->go(['/notice/item/create']);
// wrong data
$I->testForm('#notice-form', 'Item', [
    'owner_id' => 123, // its not saved
], [
    'users[]' => 1, // not ot admin )
    'partners[]' => 3, // not to another customer partner
    'message' => '', // required
    'date_from' => '28/12/2015', // invalid format
    'date_to' => '2015-12-28', // can not be less than date_from
]);
// correct data
$I->testForm('#notice-form', 'Item', [
    'partners[]' => 2,
    'users[]' => 3, // its my partner
    'message' => 'test message',
    'date_from' => '2015-10-10',
    'date_to' => '2015-10-10',
]);
$I->seeElement('.alert-success');