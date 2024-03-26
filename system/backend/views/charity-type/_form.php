<?php

use backend\models\CharityType;
use backend\models\CharityTypeSource;
use backend\models\ReceiverType;
use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\select2\Select2;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CharityType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="charity-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">

            <?= $form->field($model, 'charity_type_source_id')->widget(Select2::classname(),[
                    'data' => CharityTypeSource::getListCharityTypeSource(),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_charity_type'),
                        'value' => $model->charity_type_source_id,
                        'disabled' => $model->scenario === CharityType::SCENARIO_UPDATE,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'package')->widget(MaskMoney::classname(), [
                    'pluginOptions' => [
                        'prefix' => 'RP ',
                        'allowNegative' => false
                    ],
                ])->hint(Yii::t('app', 'fill_in_the_total_package_provisions_for_the_type_of_charity_that_has_been_packaged'));
            ?>
        </div>
    
        <div class="col-lg-4">
            <?= $form->field($model, 'desc')->textArea(['maxlength' => true, 'placeholder' => Yii::t('app', 'description')]) ?>
            
            <?= $form->field($model, 'min')->widget(MaskMoney::classname(), [
                    'pluginOptions' => [
                        'prefix' => 'RP ',
                        'allowNegative' => false
                    ],
                ]);
            ?>
            
            <?= $form->field($model, 'max')->widget(MaskMoney::classname(), [
                    'pluginOptions' => [
                        'prefix' => 'RP ',
                        'allowNegative' => false
                    ],
                ]);
            ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'is_rice')->checkbox() ?>
        
            <?= $form->field($model, 'total_rice')->textInput([
                'style' => $model->is_rice ? 'display:block;' : 'display:none;',
                'type' => 'number',
                'step' => '0.1',
                'placeholder' => Yii::t('app', 'total_rice')
                ])
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
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<< JS
    var isRiceCheckbox = document.getElementById('charitytype-is_rice');
    var totalRiceInput = document.getElementById('charitytype-total_rice');

    if (isRiceCheckbox.checked) {
        totalRiceInput.style.display = 'block';
    } else {
        totalRiceInput.style.display = 'none';
        totalRiceInput.value = null;
    }

    isRiceCheckbox.addEventListener('change', function() {
        if (isRiceCheckbox.checked) {
            totalRiceInput.style.display = 'block';
        } else {
            totalRiceInput.style.display = 'none';
            totalRiceInput.value = null;
        }
    });
JS;

$this->registerJs($js);
?>