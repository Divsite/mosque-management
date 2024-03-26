<?php

use backend\models\CharityType;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

?>

<?php $form = ActiveForm::begin(['method' => 'post']); ?>
<div class="row">
    <div class="col-lg-6">
        <label class="form-label"><?= Yii::t('app', 'payment_date') ?></label>
        <?= DatePicker::widget([
            'name' => 'payment_date',
            'id' => 'payment_date',
            'options' => ['placeholder' => Yii::t('app', 'select_date')],
            'value' => Yii::$app->request->post('payment_date'),
            'pluginOptions' => [
                'autoclose' => true,
                'startView' => 'days',
                'minViewMode' => 'days',
                'format' => 'yyyy-mm-dd',
            ],
            'pluginEvents' => [
                'changeDate' => new JsExpression('function (e) { 
                    checkForm();
                }'),
            ],
        ]);
        ?>
    </div>

    <div class="col-lg-6">
        <label class="form-label"><?= Yii::t('app', 'type_charity_id') ?></label>
        <?= Select2::widget([
            'name' => 'type_charity_id',
            'id' => 'type_charity_id',
            'data' => ArrayHelper::map(CharityType::find()->with('charitySource')->all(), 'id', 'charitySource.name'),
            'options' => ['placeholder' => Yii::t('app', 'select_type')],
            'value' => Yii::$app->request->post('type_charity_id'),
            'pluginOptions' => [
                'allowClear' => true,
            ],
            'pluginEvents' => [
                'change' => new JsExpression('function (e) { checkForm() }'),
            ],
        ]);
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$js = <<< JS
var paymentDateVal = null;
var typeVal = null;
var form = $('form');

$('#payment_date').on('change', function () {
    paymentDateVal = $(this).val();
    checkForm();
});

$('#type_charity_id').on('change', function () {
    typeVal = $(this).val();
    checkForm();
});

function checkForm() {
    console.log(typeVal, 'typeVal');
    console.log(paymentDateVal, 'paymentDateval');
    if (paymentDateVal && typeVal) {
        form.submit();
    }
}

$('#refresh-icon').click(function () {
    location.reload();
});
JS;

$this->registerJs($js);
?>
