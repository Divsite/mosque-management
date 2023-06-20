<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseStringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\Branch;
use backend\models\BranchCategory;
use backend\models\OwnerStatus;
use kartik\date\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Branch */
/* @var $form yii\widgets\ActiveForm */

$code_digit  = 3;
$code_prefix = 'BCH';
$code_model  = Branch::find()->where(['LIKE', 'code', $code_prefix])->max('code');
$code_init   = (int) BaseStringHelper::byteSubstr($code_model, strlen($code_prefix), strlen($code_prefix) + $code_digit);
$code_seq    = str_pad($code_init + 1 , $code_digit, '0', STR_PAD_LEFT);
$code_format = $code_prefix . $code_seq;

?>

<div class="branch-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'value' => $model->isNewrecord ? $code_format : $model->code, 'readonly' => true]) ?>

            <?= $form->field($model, 'bch_type')->widget(Select2::classname(),[
                    'data' => ['CENTER' => 'CENTER', 'SUB' => 'SUB'],
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_type_branch'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'bch_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'bch_address')->textarea(['maxlength' => true, 'rows' => 6]) ?>

            <?= $form->field($model, 'bch_category_id')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(BranchCategory::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_category'),
                        'value' => $model->bch_category_id,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>
            
            <?= $form->field($model, 'development_year')->widget(DatePicker::classname(),[
                    'model' => $model,
                    'attribute' => 'development_year',
                    'options' => ['class' => 'form-control'],
                    'type' => DatePicker::TYPE_INPUT,
                        'pluginOptions' => [
                            'format' => 'yyyy',
                            'minViewMode' => 2,
                            'maxViewMode' => 2,
                            'autoclose' => true,
                        ],
                    ]);
                ?>

        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'floor_area')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'floor_total')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'desc')->textarea(['maxlength' => true, 'rows' => 6]) ?>

            <?= $form->field($model, 'geographic_coordinate')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'property_value')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'owner_status_id')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(OwnerStatus::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_status'),
                        'value' => $model->owner_status_id,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'building_owner')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'permit_certification')->textInput(['maxlength' => true]) ?>

            <?php $image = $model->bch_image && is_file(Yii::getAlias('@webroot') . $model->bch_image) ? $model->bch_image : '/images/no_background.jpg'; ?>

            <?= $form->field($model, 'bch_image', [
                    'template' => '
                    {label}
                    <div id="preview">
                    <img id="img-preview" src="'. Url::base() . $image .'" alt="branch-image" />
                    </div>
                    {input}
                    {error}',
                ])->fileInput(['accept' => 'image/*']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$js = <<< JS

$('#branch-bch_image').on('change', function(e) {
    e.preventDefault();
    readURL(this);
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#img-preview').attr('src', '$image');
    }
}

JS;

$css = <<< CSS

#preview {
    border: 1px solid #ddd;
    padding: 20px;
    margin: 0 0 20px;
}

#preview img {
    width: 100%;
    max-height: 290px;
}

CSS;

$this->registerJs($js);
$this->registerCss($css);
?>