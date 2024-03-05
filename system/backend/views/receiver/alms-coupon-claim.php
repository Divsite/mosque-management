<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver Resident */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'image_upload_documentation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'receivers'), 'url' => ['view', 'id' => $receiver->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="receiver-update-officer-form">
    <div class="card">
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
            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($receiverDocumentationImage, 'url[]')->widget(FileInput::classname(), [
                        'options' => [
                            'multiple' => 'true',
                            'accept' => 'image/*'
                        ],
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?php $homeImage = $model->resident->home_image &&
                                        is_file(Yii::getAlias('@webroot') . $model->resident->home_image) ?
                                        $model->resident->home_image : '/images/no_photo.jpg'; ?>

                    <?= $form->field($model->resident, 'home_image', [
                            'template' => '
                            {label}
                            <div id="preview">
                            <img id="img-preview" src="'. Url::base() . $homeImage .'" alt="HomeIdentityImage" />
                            </div>
                            {input}
                            {error}',
                        ])
                        ->fileInput(['accept' => 'image/*'])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <br>
                <?= Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<?php
$js = <<< JS

$('#resident-home_image').on('change', function(e) {
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
        $('#img-preview').attr('src', '$homeImage');
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