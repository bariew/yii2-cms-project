<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that Campaign create works');
$updateUrl = ['/campaign/partner-item/update', 'id' => 1];

// CUSTOMER
$I->customerLogin();
$I->go($updateUrl);
$I->seeElement('.alert-danger');// partner campaign waits for partner to approve it

// PARTNER
$I->partnerLogin();
$I->go($updateUrl);

// ADDING MATERIAL
$I->click('.material-add-button');
// I am on material add page
$I->click('.material-add-image');
// I am on material add page
// wrong data
$I->testMultipleForm('#material-form', [
    'Material' => [
        'correct' => ['owner_id' => 'asd'], // not validated
        'wrong'   => ['title' => ''],
    ],
    'MaterialRule[new-0]' => [
        'correct' => [
            'rule_id' => 1, // we will not see error since it validates after parent material saving
        ],
        'wrong'   => [
            'operator' => '<<',
            'value' => '',
        ],
    ]
]);
// correct data
$I->testMultipleForm('#material-form', [
    'Material' => [
        'correct' => ['title' => 'partner test material', 'description' => 'partner test description'],
        'wrong'   => [],
    ],
    'MaterialRule[new-0]' => [
        'correct' => [
            'rule_id' => 1,
            'operator' => '=',
            'value' => 'Mercedes',
        ],
        'wrong'   => [],
    ]
]);

// UPDATE partner campaign
$I->go($updateUrl);
$I->seeElement('#material-view-'. \app\modules\campaign\models\Material::find()->max('id'));
$I->testForm('#partner-campaign-form', 'PartnerItem', [], [
    'status' => \app\modules\campaign\models\PartnerItem::STATUS_ACCEPT
]);
$I->testForm('#partner-campaign-form', 'PartnerItem', [
    'status' => \app\modules\campaign\models\PartnerItem::STATUS_READY
]);
$I->seeElement('.alert-success');
$I->go($updateUrl);
$I->seeElement('.alert-danger'); // now partner has to wait for customer to approve

// CUSTOMER
$I->customerLogin();
$I->go($updateUrl);
$I->testForm('#partner-campaign-form', 'PartnerItem', [], [
    'status' => \app\modules\campaign\models\PartnerItem::STATUS_NEW
]);
$I->testForm('#partner-campaign-form', 'PartnerItem', [
    'status' => \app\modules\campaign\models\PartnerItem::STATUS_ACCEPT
]);
$I->seeElement('.alert-success');
$I->go($updateUrl);
$I->seeElement('.alert-danger'); // campaign is in process

// PARTNER
$I->partnerLogin();
$I->go($updateUrl);
$I->seeElement('.alert-danger'); // campaign is in process