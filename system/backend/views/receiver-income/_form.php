<?php

use backend\models\Officer;
use backend\models\ReceiverClass;
use backend\models\ReceiverExpense;
use backend\models\ReceiverIncome;
use backend\models\ReceiverIncomeType;
use backend\models\ReceiverOperationalType;
use backend\models\ReceiverType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\money\MaskMoney;
use kidzen\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\TbInvoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receiver-expense-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<div class="row">
    <div class="col-lg-6">
        <?= $form->field($model, 'receiver_type_id')->widget(Select2::classname(),[
                'data' => ReceiverType::getListReceiverType(),
                'options' => [
                    'placeholder' => Yii::t('app', 'select_type'),
                    'value' => $model->receiver_type_id,
                    'disabled' => $model->scenario === ReceiverIncome::SCENARIO_UPDATE,
                ],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]);
        ?>
        <?= $form->field($model, 'receiver_income_type_id')->widget(Select2::classname(),[
                'data' => ReceiverIncomeType::getListReceiverIncomeType(),
                'options' => [
                    'placeholder' => Yii::t('app', 'select_income_type'),
                    'value' => $model->receiver_income_type_id,
                    'disabled' => $model->scenario === ReceiverIncome::SCENARIO_UPDATE,
                ],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]);
        ?>
    </div>

    <div class="col-lg-6">
        <?= $form->field($model, 'description')->textArea(['placeholder' => Yii::t('app', 'description'), 'rows' => 6]) ?>
    </div>
    
</div>

<hr style="border-top: 2px double #e67e22">

<div class="padding-v-md">
    <div class="line line-dashed"></div>
</div>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 100, // the maximum times, an element can be cloned (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $detailIncomes[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'name',
        'money',
        'rice',
    ],
]);

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-envelope"></i> <?= Yii::t('app', 'detail_income') ?>
        <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= Yii::t('app', 'add_item') ?> </button>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body container-items"><!-- widgetContainer -->
        <?php foreach ($detailIncomes as $index => $item): ?>
            <div class="item panel panel-default"><!-- widgetBody -->
                <div class="panel-heading">
                    <span class="panel-title-address"></span>
                    <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <?php
                        // necessary for update action.
                        if (!$item->isNewRecord) {
                            echo Html::activeHiddenInput($item, "[{$index}]id");
                        }
                    ?>
                    <div class="row">
                        <div class="col-lg-4">
                            <?= $form->field($item, "[{$index}]name")->textArea(['maxlength' => true, 'rows' => 6]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($item, "[{$index}]rice")->textInput(['maxlength' => true, 'type' => 'number', 'step' => '0.1', 'value' => $item->isNewRecord ? 0 : null]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($item, "[{$index}]money")->widget(MaskMoney::classname(), [
                                'pluginOptions' => [
                                    'prefix' => 'RP ',
                                    'allowNegative' => false
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php DynamicFormWidget::end(); ?>

<br>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

</div>


<?php
$js = '
$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
console.log("beforeInsert");
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
if (! confirm("Are you sure you want to delete this item?")) {
    return false;
}
return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
alert("Limit reached");
});

$("#dynamic-form").on("beforeSubmit", function (e) {
    var form = $(this);
    console.log(form);
    if (form.find(".has-error").length) {
        return false;
    }
    // Lakukan penanganan khusus di sini jika diperlukan
    return true; // Form akan disubmit
});

';


$this->registerJs($js);
