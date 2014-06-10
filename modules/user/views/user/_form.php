<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\user\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'status')->dropDownList($model->statusList()) ?>

    <?php echo $form->field($model, 'role')->dropDownList($model->roleList()) ?>

    <?php echo $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'company_name')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
