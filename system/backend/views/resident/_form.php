<?php

use backend\models\Education;
use backend\models\Gender;
use backend\models\MarriedStatus;
use backend\models\Nationality;
use backend\models\Religion;
use backend\models\ResidenceStatus;
use backend\models\Resident;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Resident */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resident-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <div class="row">

        <div class="col-lg-3">

            <?= $form->field($model, 'nik')->textInput() ?>

            <?= $form->field($model, 'nationality_id')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(Nationality::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_nationality'),
                        'value' => $model->nationality_id,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'birth_place')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'birth_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => Yii::t('app', 'select_date')],
                'pluginOptions' => [
                    'autoclose' => true
                ]
            ]);
            ?>

            <?= $form->field($model, 'gender_id')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(Gender::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_gender'),
                        'value' => $model->gender_id,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'family_head_status')->radioList( [Resident::FAMILY_HEAD_YES => Yii::t('app', 'yes'), Resident::FAMILY_HEAD_NO => Yii::t('app', 'no')] ); ?>

            <?= $form->field($model, 'dependent_number')->textInput() ?>

        </div>
        
        <div class="col-lg-3">

            <?= $form->field($model, 'residence_status_id')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(ResidenceStatus::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_residence_status'),
                        'value' => $model->residence_status_id,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'citizen_association_id')->textInput() ?>

            <?= $form->field($model, 'neighborhood_association_id')->textInput() ?>

            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-lg-3">

            <?= $form->field($model, 'married_status_id')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(MarriedStatus::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_married_status'),
                        'value' => $model->married_status_id,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'religion_id')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(Religion::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_religion'),
                        'value' => $model->religion_id,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'education_id')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(Education::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_education'),
                        'value' => $model->education_id,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>
            
            <?= $form->field($model, 'education_major_id')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(Education::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_education_major'),
                        'value' => $model->education_major_id,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'interest')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-lg-3">

            <?php $identity_card_image = $model->identity_card_image && is_file(Yii::getAlias('@webroot') . $model->identity_card_image) ? $model->identity_card_image : '/images/card.jpg'; ?>

            <?= $form->field($model, 'identity_card_image', [
                    'template' => '
                    {label}
                    <div id="preview">
                    <img id="img-preview" src="'. Url::base() . $identity_card_image .'" alt="identity-image" />
                    </div>
                    {input}
                    {error}',
                ])->fileInput(['accept' => 'image/*']) ?>

            <?php $home_image = $model->home_image && is_file(Yii::getAlias('@webroot') . $model->home_image) ? $model->home_image : '/images/home.jpg'; ?>

            <?= $form->field($model, 'home_image', [
                    'template' => '
                    {label}
                    <div id="preview">
                    <img id="img-preview" src="'. Url::base() . $home_image .'" alt="home-image" />
                    </div>
                    {input}
                    {error}',
                ])->fileInput(['accept' => 'image/*']) ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$js = <<< JS

$('#resident-identity_card_image').on('change', function(e) {
    e.preventDefault();
    readURLIdentity(this);
});

$('#resident-home_image').on('change', function(e) {
    e.preventDefault();
    readURLHome(this);
});

function readURLIdentity(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#img-preview').attr('src', '$identity_card_image');
    }
}

function readURLHome(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#img-preview').attr('src', '$home_image');
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