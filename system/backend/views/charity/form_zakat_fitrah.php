<?php

use backend\models\CharityZakatFitrahPackage;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row">

    <div class="col-lg-4">

    <p class="terms"><?= Yii::t('app', 'terms') ?> : </p>
    <div class="terms_content">
        <span class="label"><?= Yii::t('app', 'package') ?> : </span> <span id="package"></span>
    </div>

    <?= Html::label(Yii::t('app', 'select_package'), 'package', ['class' => 'control-label']) ?>
    <?= Select2::widget([
        'id' => 'zakat_fitrah_package',
        'name' => 'zakat_fitrah_package',
        'data' => ArrayHelper::map(CharityZakatFitrahPackage::find()->all(), 'id', 'name'),
        'value' => $charityZakatFitrah->charity_zakat_fitrah_package_id,
        'options' => [
            'placeholder' => Yii::t('app', 'select_package'),
            'onChange' => '$.post("' . Url::base() . '/charity/package-calculation?id=" + $(this).val() + "&type_charity_id=" + $("#type_charity_id").val(), function(data) {
                what = JSON.parse(data);
                console.log(what.payment_total_package)
                $("#payment_total_package").val(what.payment_total_package).trigger("input");
            });',
        ],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ]) ?>

    <?= $form->field($charityZakatFitrah, 'payment_total')->textInput([
            'id' => 'payment_total_package',
            'readonly' => true,
        ]);
    ?>

    </div>
    
    <div class="col-lg-4">
        
        <?= $form->field($charityZakatFitrah, 'customer_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityZakatFitrah, 'customer_email')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="col-lg-4">

        <?= $form->field($charityZakatFitrah, 'customer_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($charityZakatFitrah, 'customer_address')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    </div>

</div>