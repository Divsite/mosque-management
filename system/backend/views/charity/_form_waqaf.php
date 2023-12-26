<?php 
use kartik\money\MaskMoney;
?>
<div class="row">

    <div class="col-lg-4">

        

    </div>
    
    <div class="col-lg-4">
        
        <?= $form->field($charityWaqaf, 'customer_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityWaqaf, 'customer_email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityWaqaf, 'customer_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityWaqaf, 'customer_address')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    </div>

    <div class="col-lg-4">

        <?= $form->field($charityWaqaf, 'payment_total')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'prefix' => 'RP ',
                'allowNegative' => false
            ]
        ]);
        ?>

    </div>

</div>