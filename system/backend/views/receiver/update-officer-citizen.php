<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver Resident */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'update_officer_and_citizen');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="receiver-update-officer-form">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
                <i class="fas fa-expand"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">

            <?php $form = ActiveForm::begin(); ?>

                <?= Html::label(Yii::t('app', 'resident_id'), 'resident_id', ['class' => 'control-label']) ?>
                <?= Select2::widget([
                    'id' => 'receiver-resident_id',
                    'name' => 'receiver-resident_id',
                    'data' => $residentDatas,
                    'value' => $selectedResidents,
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_resident'),
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]) ?>

                <?= Html::label(Yii::t('app', 'officer_id'), 'officer_id', ['class' => 'control-label']) ?>
                <?= Select2::widget([
                    'id' => 'receiver-officer_id',
                    'name' => 'receiver-officer_id',
                    'data' => $officerDatas,
                    'value' => $selectedOfficers,
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_officer'),
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]) ?>

                <div class="form-group">
                    <br>
                    <?= Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
