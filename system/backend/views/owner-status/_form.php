<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OwnerStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="owner-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
