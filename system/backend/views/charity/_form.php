<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Charity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="charity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_charity_id')->textInput() ?>

    <?= $form->field($model, 'customer_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_number')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payment_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_date')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
