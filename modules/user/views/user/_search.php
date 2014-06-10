<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\user\models\UserSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'email') ?>

    <?php echo $form->field($model, 'role') ?>

    <?php echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'company_name') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
