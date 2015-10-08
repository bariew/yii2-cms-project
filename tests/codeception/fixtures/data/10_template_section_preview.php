<?php
ob_start();
require Yii::getAlias('@app/modules/template/views/section-preview/section.php');
$sectionContent = ob_get_clean();
ob_start();
require Yii::getAlias('@app/modules/template/views/section-preview/material.php');
$materialContent = ob_get_clean();
return [
    'preview_1' => [
        'owner_id' => 2,
        'section_content' => $sectionContent,
        'material_content' => $materialContent,
    ],
    'preview_2' => [
        'owner_id' => 4,
        'section_content' => $sectionContent,
        'material_content' => $materialContent,
    ],
];
