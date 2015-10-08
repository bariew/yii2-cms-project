<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that User create work');

// ADMIN
$I->login();
$I->go(['/user/user/create']);
$I->testForm('#user-form', 'User', [], [
    'username' => 'admin', // not unique
    'owner_id' => 'asd',
    'email' => 123,
    'phone' => 'DN',
    'password' => '',
    'notify' => 'DN',
    'permissions[]' => 'uploader', // basic role is required
]);

$I->testForm('#user-form', 'User', [
    'username' => 'test',
    'owner_id' => '1',
    'email' => 'test@test.test',
    'phone' => '+79125675656',
    'password' => 'admin',
    'notify' => '1',
    'permissions[]' => 'partner',
]);
$I->seeElement('.alert-success');

//CUSTOMER
$I->customerLogin();
$I->go(['/user/user/create']);
$I->testForm('#user-form', 'User', [], [
    'username' => 'admin', // not unique
    'owner_id' => 3,
    'email' => 123,
    'phone' => 'DN',
    'password' => '',
    'notify' => 'DN',
    'permissions[]' => 'root',
]);

$I->testForm('#user-form', 'User', [
    'username' => 'test1',
    'owner_id' => '2',
    'email' => 'test1@test1.test1',
    'phone' => '+79125675656',
    'password' => 'admin',
    'notify' => '1',
    'permissions[]' => 'partner',
]);
$I->seeElement('.alert-success');
