<?php 
use kartik\money\MaskMoney;
?>

<div class="row">

    <div class="col-lg-4">

        

    </div>
    
    <div class="col-lg-4">
        
        <?= $form->field($charityZakatMal, 'customer_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityZakatMal, 'customer_email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityZakatMal, 'customer_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityZakatMal, 'customer_address')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    </div>

    <div class="col-lg-4">

        <?= $form->field($charityZakatMal, 'payment_total')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'prefix' => 'RP ',
                'allowNegative' => false
            ]
        ]);
        ?>

    </div>

</div>