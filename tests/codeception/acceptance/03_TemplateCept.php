<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that Template create work');

// ADMIN
$I->login();
$I->go(['/template/item/create']);
$I->testForm('#item-form', 'Item', [], [
    'title' => '',
    'status' => 123,
    'type' => 123,
    'partner_type' => 123,
]);

$I->testForm('#item-form', 'Item', [
    'title' => 'test title',
    'status' => 0,
    'type' => 0,
    'partner_type' => 0,
    'customers[]' => '1',
    'sections[]' => '1',
    'description' => 'test descr',
]);
$I->seeElement('.alert-success');
