<?php

use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use yii\web\JsExpression;

?>

<?php $form = ActiveForm::begin(['method' => 'post']); ?>

<label class="form-label"><?= Yii::t('app', 'registration_year') ?></label>
<?= DatePicker::widget([
    'name' => 'registration_year',
    'options' => ['placeholder' => Yii::t('app', 'select_years')],
    'pluginOptions' => [
        'autoclose' => true,
        'startView' => 'years',
        'minViewMode' => 'years',
        'format' => 'yyyy',
    ],
    'pluginEvents' => [
        'changeDate' => new JsExpression('function (e) { $(this).closest("form").submit(); }'),
    ],
]);
?>

<?php ActiveForm::end(); ?>

<?php
$js = <<< JS
    $('#registration_year').on('changeDate', function () {
        $(this).closest('form').submit();
    });
JS;

$this->registerJs($js);
?>