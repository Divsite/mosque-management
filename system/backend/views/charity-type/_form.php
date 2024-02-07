<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CharityType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="charity-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nama']) ?>
        
            <?= $form->field($model, 'desc')->textArea(['maxlength' => true, 'placeholder' => 'Deskripsi']) ?>
        </div>
    
        <div class="col-lg-4">
            <?= $form->field($model, 'min')->textInput(['maxlength' => true, 'placeholder' => 'Optional, min uang jika ada']) ?>
        
            <?= $form->field($model, 'max')->textInput(['maxlength' => true, 'placeholder' => 'Optional, max uang jika ada']) ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'is_rice')->checkbox(['maxlength' => true, 'placeholder' => 'Optional, min uang jika ada']) ?>
        
            <?= $form->field($model, 'total_rice', ['inputOptions'=>['style'=>'display:none']])->textInput(['maxlength' => true, 'style' => 'display:none;', 'placeholder' => 'Optional, max uang jika ada']) ?>
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

    isRiceCheckbox.addEventListener('change', function() {
        if (isRiceCheckbox.checked) {
            totalRiceInput.style.display = 'block';
        } else {
            totalRiceInput.style.display = 'none';
        }
    });
JS;

$this->registerJs($js);
?>