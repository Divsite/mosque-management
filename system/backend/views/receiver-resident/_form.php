<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver Resident */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receiver-complaint-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
