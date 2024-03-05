<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EnvMember */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="env-member-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'env_id')->textInput() ?>

    <?= $form->field($model, 'env_division_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_chief')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
