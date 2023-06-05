<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ReceiverSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receiver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'receiver_type_id') ?>

    <?= $form->field($model, 'receiver_class_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'citizens_association_id') ?>

    <?php // echo $form->field($model, 'neighborhood_association_id') ?>

    <?php // echo $form->field($model, 'registration_year') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'barcode_number') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
