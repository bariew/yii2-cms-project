<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that SectionPreview create works');

// ADMIN
$I->login();
$I->go(['/template/section-preview/create']);
// wrong data
$I->attachFile('#sectionpreview-file', 'mmc.pdf');
$I->testForm('#preview-form', 'SectionPreview', [], [
    'file' => 123,
    'owner_id' => 123,
    'img_width' => 'asd',
    'img_height' => 'sdf',
    'img_top' => '',
    'img_left' => '',
    'section_content' => '',
    'material_content' => '',
]);
// correct data
$I->attachFile('#sectionpreview-file', 'template_background.png');
$I->testForm('#preview-form', 'SectionPreview', [
    'owner_id' => 2,
    'sections[]' => 1,
    'img_width' => '756',
    'img_height' => '410',
    'img_top' => '702',
    'img_left' => '19',
    'section_content' => 'Section content',
    'material_content' => 'Material content',
]);
$I->seeElement('.alert-success');
