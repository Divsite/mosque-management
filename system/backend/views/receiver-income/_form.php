<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ReceiverIncome */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receiver-income-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'receiver_income_type_id')->textInput() ?>

    <?= $form->field($model, 'branch_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registration_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'amount_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_rice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
