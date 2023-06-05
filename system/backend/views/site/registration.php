<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\UserLevel;
use backend\models\UserType;
use backend\models\Branch;
use backend\models\Customer;
use backend\models\Division;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$select_level = ArrayHelper::map(UserLevel::find()->where(['type' => $model->isNewRecord ? 'B' : $model->type])->asArray()->all(), function($model, $defaultValue) {

    return md5($model['code']);

}, function($model, $defaultValue) {

        return sprintf('%s', $model['name']);
    }
);

// $select_type = ArrayHelper::map(UserType::find()->asArray()->all(),'code', function($model, $defaultValue) {

//         return $model['table'];
//     }
// );

// $select_code = ArrayHelper::map(Branch::find()->asArray()->all(),'code', function($model, $defaultValue) {

//         return $model['bch_name'];
//     }
// );

// if ($model->type === 'C')
// {
//     $select_code = ArrayHelper::map(Customer::find()->asArray()->all(),'code', function($model, $defaultValue) {

//             return $model['cus_name'];
//         }
//     );
// }

?>

<div class="card table-card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
            <i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="card-text">
            <div class="user-create">
                <div class="user-form">
                    <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class="col-lg-4">

                                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control border-input']) ?>
                                
                                <?= $form->field($model, 'password_repeat')->passwordInput(['class' => 'form-control border-input']) ?>

                            </div>

                            <div class="col-lg-4">

                                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'division_id')->widget(Select2::classname(),[
                                        'data' => Division::getListNameDivision(),
                                        'options' => [
                                            'placeholder' => 'Pilih Divisi',
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => false
                                        ],
                                    ]);
                                ?>

                                <?= $form->field($profile, 'gender')->widget(Select2::classname(),[
                                    'data' => [ 'PRIA' => 'PRIA', 'WANITA' => 'WANITA'],
                                    'options' => [
                                        'placeholder' => 'Pilih ...',
                                        'value' => $profile->isNewRecord ? 'PRIA' : $profile->gender,
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => false
                                    ],
                                ]) ?>

                            </div>

                            <div class="col-lg-4">

                                <?php  $image = $model->image && is_file(Yii::getAlias('@webroot') . $model->image) ? $model->image : '/images/no_photo.jpg'; ?>

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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= Html::submitButton('Daftar', ['class' => 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="text-center"><i><?= Html::encode($this->title) ?></i></div>
    </div>
</div>

<?php

// $url_reff_type = Url::to(['reff/user-type']);

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
