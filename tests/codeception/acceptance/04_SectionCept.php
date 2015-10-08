<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that Section create works');

// ADMIN
$I->login();
$I->go(['/template/section/create']);
$I->testForm('#section-form', 'Section', [], [
    'title' => '',
    'status' => 123,
    'type' => 123,
    'width' => 'asd',
    'height' => 'asd',
    'material_max' => 'asd',
    'price' => 'asd',
]);

$I->testForm('#section-form', 'Section', [
    'title' => 'Test section',
    'status' => 0,
    'type' => 0,
    'templates[]' => '1',
    'description' => 'test descr',
    'width' => 100,
    'height' => 100,
    'material_max' => 3,
    'price' => 100,
    'price_comment' => 'test comment',
]);
$I->seeElement('.alert-success');
