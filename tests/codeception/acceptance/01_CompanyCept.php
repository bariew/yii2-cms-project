<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that company create work');

// ADMIN
$I->login();
$I->go(['/user/company/create']);
$I->testForm('#company-form', 'Company', [], [
    'title' => 'EXAMPLE', // not unique
    'owner_id' => 'asd',
    'type' => 123,
    'outer_id' => 'DN' // not unique
]);

$I->testForm('#company-form', 'Company', [
    'title' => 'new title',
    'owner_id' => '1',
    'type' => 0,
    'outer_id' => 'AS',
]);
$I->seeElement('.alert-success');

//CUSTOMER
$I->customerLogin();
$I->go(['/user/company/create']);
$I->testForm('#company-form', 'Company', [], [
    'title' => 'EXAMPLE', // not unique
    'type' => 123,
    'outer_id' => 'DN' // not unique
]);

$I->testForm('#company-form', 'Company', [
    'title' => 'new title customer',
    'type' => 0,
    'outer_id' => 'AS1',
]);
$I->seeElement('.alert-success');
