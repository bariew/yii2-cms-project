<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that Rule create works');

// ADMIN
$I->login();
$I->go(['/template/rule/index']);
// index page
$I->testForm('#rule-create-form', 'RuleSearch', [
    'owner_id' => 2,
    'partner_type' => 1,
]);
$I->seeElement('.alert-danger');
$I->testForm('#rule-create-form', 'RuleSearch', [
    'owner_id' => 1,
    'partner_type' => 0,
]);
// form page
// wrong data
$I->testForm('#rule-form', 'Rule', [
    'owner_id' => 1,
    'partner_type' => 0,
], [
    'title' => '',
    'form_type' => 123,
    'field' => 123,
    'values' => 'some wrong parsed string',
]);
$I->testForm('#rule-form', 'Rule', [
    'owner_id' => 1,
    'partner_type' => 0,
    'form_type' => 2,
], [
    'title' => '',
    'field' => '',
    'values' => '', // required for some input types
]);
// correct data
$I->testForm('#rule-form', 'Rule', [
    'owner_id' => 1,
    'partner_type' => 0,
    'title' => 'Test rule',
    'form_type' => 2,
    'field' => 'car_brand',
    'values' =>
"1=option1;1
2=option2;0",
    'sections[]' => '1',
]);
$I->seeElement('.alert-success');
