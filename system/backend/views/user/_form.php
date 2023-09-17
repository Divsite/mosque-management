<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\UserLevel;
use backend\models\UserType;
use backend\models\Branch;
use backend\models\Customer;
use backend\models\Populate;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$select_level = ArrayHelper::map(UserLevel::find()->where(['type' => 'W'])->asArray()->all(), function($model, $defaultValue) {

    return md5($model['code']);

}, function($model, $defaultValue) {

        return sprintf('%s', $model['name']);
    }
);

$select_type = ArrayHelper::map(UserType::find()->asArray()->all(),'code', function($model, $defaultValue) {

        return $model['table'];
    }
);

$select_code = ArrayHelper::map(Branch::find()->asArray()->all(),'code', function($model, $defaultValue) {

        return $model['bch_name'];
    }
);

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-lg-4">

            <?= $form->field($model, 'type')->widget(Select2::classname(),[
                    'data' => $select_type,
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_type'),
                        'value' => $model->isNewRecord ? 'B' : $model->type,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'code')->widget(Select2::classname(),[
                    'data' => $select_code,
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_code'),
                        'value' => $model->isNewRecord ? 'B' : $model->code,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        // use matcher to search customize
                        'matcher' => new \yii\web\JsExpression('function(params, data) {
                            if ($.trim(params.term) === "") {
                                return data;
                            }

                            if (typeof data.text === "undefined") {
                                return null;
                            }

                            var keywords = params.term.split(" ");
                            var text = data.text.toLowerCase();
                            for (var i = 0; i < keywords.length; i++) {
                                if (text.indexOf(keywords[i]) === -1) {
                                    return null;
                                }
                            }
                            return data;

                        }'),
                    ],
                ]);
            ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control border-input']) ?>
            
            <?= $form->field($model, 'password_repeat')->passwordInput(['class' => 'form-control border-input']) ?>

        </div>

        <div class="col-lg-4">

            <?= $form->field($model, 'level')->widget(Select2::classname(),[
                    'data' => $select_level,
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_level'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->widget(Select2::classname(),[
                'data' => [ 10 => 'ACTIVE', 9 => 'INACTIVE', 0 => 'DELETED' ],
                'options' => [
                    'placeholder' => Yii::t('app', 'select_status'),
                    'value' => $model->isNewRecord ? 10 : $model->status,
                ],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>

        </div>

        <div class="col-lg-4">

            <?php 

            $image = $model->image && is_file(Yii::getAlias('@webroot') . $model->image) ? $model->image : '/images/no_photo.jpg';

            ?>

            <?= $form->field($model, 'image', [
                    'template' => '
                    {label}
                    <div id="preview">
                    <img id="img-preview" src="'. Url::base() . $image .'" alt="user image" />
                    </div>
                    {input}
                    {error}',
                ])->fileInput(['accept' => 'image/*']) ?>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12 text-center">
            
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$url_reff_type = Url::to(['reff/user-type']);

$js = <<< JS

$('#user-image').on('change', function(e) {
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

$('#user-type').on('change', function(e) {

    var this_val = $(this).val();

    $.post('$url_reff_type' + '?code=' + this_val, function(data) { 

            if (data.status) {

                /**
                 * select level function by type
                 * level selected from type
                 * **/
                data_level = '<option></option>';

                $.each(data.data_level, function(i, val) {
                    data_level+= '<option value="' + val.code + '">' + val.name + '</option>';
                });

                $("#user-level").html(data_level);

                /**
                 * select code function by type
                 * code selected from type
                 * **/

                // Clear and populate the Select2 with new data
                $("#user-code").val(null).trigger("change"); // Clear existing selection
                $("#user-code").empty(); // Clear existing options

                data_code = '<option></option>';

                $.each(data.data_code, function(i, val) {

                    val_name = '';

                    if (this_val == 'B') {
                        val_name = val.bch_name ;
                    } 
                    if (this_val == 'C') {
                        val_name = val.cus_name ;
                    }
                    if (this_val == 'W') {
                        val_name = val.village.location.province_name + ' ' +
                                    val.village.location.city_name + ' ' + 
                                    val.village.location.district_name + ' ' + 
                                    val.village.name + ' ' + 
                                    val.citizenAssociation.name + ' ' + 
                                    val.neighborhoodAssociation.name;
                    }

                    data_code+= '<option value="' + val.code + '">' + val_name + '</option>';
                    $("#user-code").append(new Option(val_name, val.code, false, false));
                });

                // $("#user-code").html(data_code);
            }

    });
});

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
