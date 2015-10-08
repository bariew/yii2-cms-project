<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that Campaign create works');

// ADMIN
$I->customerLogin();
$I->go(['/campaign/item/create']);
// wrong data
$I->testForm('#campaign-form', 'Item', [
    'owner_id' => 123, // not validated/saved from post
], [
    'partner_type' => 123,
    'title' => '',
    'partners[]' => 3, // not my partner
    'date_start' => '28/12/2015', // invalid format
    'date_end' => '2015-12-28', // can not be less than date_start
    'date_delivery' => '2015-12-30', // can not be greater than date_end
]);
// correct data
$I->testForm('#campaign-form', 'Item', [
    'partner_type' => 0,
    'title' => 'test campaign',
    'partners[]' => 2,
    'date_start' => date('Y-m-d'),
    'date_end' => date('Y-m-d', strtotime('+5days')),
    'date_delivery' => date('Y-m-d'),
]);
$I->seeElement('.alert-success');
$updateUrl = $I->getUrl();
$id = preg_replace('/.*(\d+)/', '$1', $updateUrl);

// ADDING TEMPLATE
$I->click('.template-add-link');
// I am on template select page
$I->click('template 1');
// I am on template add form
$I->testForm('form', 'Template', [], [
    'partners[]' => 1,
]);
$I->testForm('form', 'Template', [
    'partners[]' => 2,
]);
// I am on template view page
$I->go($updateUrl);
// I see added template in campaign
$I->see('template 1', 'strong');

// ADDING MATERIAL
$I->click('.material-add-button');
// I am on material add page
$I->click('.material-add-image');
// I am on material add page
$I->testForm('#material-form', 'Material', [], [
    'title' => ''
]);
$I->testForm('#material-form', 'Material', [
    'title' => 'test material',
    'description' => 'test description'
]);
$I->go($updateUrl);
$I->seeElement('#material-view-1');