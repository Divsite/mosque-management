<?php 
use kartik\money\MaskMoney;
?>
<div class="row">

    <div class="col-lg-4">

        

    </div>
    
    <div class="col-lg-4">
        
        <?= $form->field($charityInfaq, 'customer_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityInfaq, 'customer_email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityInfaq, 'customer_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityInfaq, 'customer_address')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    </div>

    <div class="col-lg-4">

        <?= $form->field($charityInfaq, 'payment_total')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'prefix' => 'RP ',
                'allowNegative' => false
            ]
        ]);
        ?>

    </div>

</div>