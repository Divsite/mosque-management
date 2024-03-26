<?php

use backend\models\ReceiverClass;
use backend\models\ReceiverClassSource;
use kartik\money\MaskMoney;
use kartik\select2\Select2;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ReceiverClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receiver-class-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'receiver_class_source_id')->widget(Select2::classname(),[
                    'data' => ReceiverClassSource::getListReceiverClassSource(),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_receiver_class'),
                        'value' => $model->receiver_class_source_id,
                        'disabled' => $model->scenario === ReceiverClass::SCENARIO_UPDATE,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'is_active')->widget(Select2::classname(),[
                'data' => [ 1 => Yii::t('app', 'active'), 0 => Yii::t('app', 'nonactive') ],
                'options' => [
                    'placeholder' => Yii::t('app', 'select_status'),
                    'value' => $model->isNewRecord ? 1 : $model->is_active,
                ],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'get_money')->widget(MaskMoney::classname(), [
                    'pluginOptions' => [
                        'prefix' => 'RP ',
                        'allowNegative' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'get_rice')->textInput([
                    'type' => 'number',
                    'step' => '0.1',
                    'placeholder' => Yii::t('app', 'get_rice'),
                    'addon' => ['append' => [
                        'content'=> 'LABEL'
                    ]],
                ])
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


