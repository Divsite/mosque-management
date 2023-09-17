<?php 
use kartik\money\MaskMoney;
?>
<div class="row">

    <div class="col-lg-4">

        <p class="terms"><?= Yii::t('app', 'terms') ?> : </p>
        <div class="terms_content">
            <span class="label"><?= Yii::t('app', 'min') ?> : </span> <span id="min"></span>
        </div>
        <div class="terms_content">
            <span class="label"><?= Yii::t('app', 'max') ?> : </span> <span id="max"></span>
        </div>
        <div class="terms_content">
            <span class="label"><?= Yii::t('app', 'rice') ?> : </span> <span id="rice"></span>
        </div>

    </div>
    
    <div class="col-lg-4">
        
        <?= $form->field($charityManually, 'customer_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityManually, 'customer_email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityManually, 'customer_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityManually, 'customer_address')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    </div>

    <div class="col-lg-4">

        <?= $form->field($charityManually, 'payment_total')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'prefix' => 'RP ',
                'allowNegative' => false
            ]
        ]);
        ?>

    </div>

</div>