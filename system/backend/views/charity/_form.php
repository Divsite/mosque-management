<?php

use backend\models\Charity;
use backend\models\CharityType;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Charity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="charity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type', ['inputOptions'=>['id'=>'type']])->widget(Select2::classname(),[
            'data' => [ Charity::CHARITY_TYPE_MANUALLY => Yii::t('app', 'charity_type_manually'), Charity::CHARITY_TYPE_AUTOMATIC => Yii::t('app', 'charity_type_automatic')],
            'options' => [
                'placeholder' => Yii::t('app', 'select_type'),
                'value' => $model->type,
            ],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]);
    ?>

    <?= $form->field($model, 'type_charity_id', ['inputOptions'=>['id'=>'type_charity_id']])->widget(Select2::classname(),[
        'data' => ArrayHelper::map(CharityType::find()->all(), 'id', 'name'),
        'options' => [
            'placeholder' => Yii::t('app', 'select_type'),
            'value' => $model->type_charity_id,
            'onChange' => '$.post("'.Url::base().'/charity/select-charity-type?id='.'" + $(this).val(), function(data) {
                    what = JSON.parse(data);
                    $("#min").text(what.min);
                    $("#max").text(what.max);
                    $("#rice").text(what.rice);
                    $("#package").text(what.package);
                }
            );',
        ],
        'pluginOptions' => [
            'allowClear' => false
        ],
        ]);
    ?>

    <div id="manually" <?= $model->type == Charity::CHARITY_TYPE_AUTOMATIC ? '' : 'style="display: none"' ?>>

        <?= $this->render('form_manually', [
            'charityManually' => $charityManually,
            'form' => $form,
        ]) ?>

    </div>

    <div id="automatic" <?= $model->type == Charity::CHARITY_TYPE_MANUALLY ? '' : 'style="display: none"' ?>>
        
        <!-- Zakat Fitrah -->
        <div id="zakat_fitrah" <?= $model->type_charity_id == 1 ? '' : 'style="display: none"' ?>>
            <?= $this->render('form_zakat_fitrah', [
                'charityZakatFitrah' => $charityZakatFitrah,
                'form' => $form,
            ]) ?>
        </div>

        <!-- Zakat Fidyah -->
        <div id="zakat_fidyah" <?= $model->type_charity_id == 2 ? '' : 'style="display: none"' ?>>
            <?= $this->render('form_zakat_fidyah', [
                'charityZakatFidyah' => $charityZakatFidyah,
                'form' => $form,
            ]) ?>
        </div>

        <!-- Infaq -->
        <div id="infaq" <?= $model->type_charity_id == 3 ? '' : 'style="display: none"' ?>>
            <?= $this->render('form_infaq', [
                'charityInfaq' => $charityInfaq,
                'form' => $form,
            ]) ?>
        </div>

        <!-- Sodaqoh -->
        <div id="sodaqoh" <?= $model->type_charity_id == 4 ? '' : 'style="display: none"' ?>>
            <?= $this->render('form_sodaqoh', [
                'charitySodaqoh' => $charitySodaqoh,
                'form' => $form,
            ]) ?>
        </div>

        <!-- Zakat Mal -->
        <div id="zakat_mal" <?= $model->type_charity_id == 5 ? '' : 'style="display: none"' ?>>
            <?= $this->render('form_zakat_mal', [
                'charityZakatMal' => $charityZakatMal,
                'form' => $form,
            ]) ?>
        </div>

        <!-- Waqaf -->
        <div id="waqaf" <?= $model->type_charity_id == 6 ? '' : 'style="display: none"' ?>>
            <?= $this->render('form_waqaf', [
                'charityWaqaf' => $charityWaqaf,
                'form' => $form,
            ]) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$css = <<< CSS
.terms {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
}

.terms_content {
    font-size: 15px;
    margin-bottom: 5px;
}
CSS;

$this->registerCss($css);


$js = <<< JS
$('#type').on('change', function (e) {
    
    let data = $(this).val();

    $("#manually").hide();
    $("#automatic").hide();

    if(data == 1) { // manually
        $("#manually").show();
        $("#automatic").hide();
        resetAutomaticTypeForm();
    } else if(data == 2) { // automatic
        $("#manually").hide();
        $("#automatic").show();
        resetManuallyTypeForm();

        $('#type_charity_id').on('change', function (e) {
            let type_charity = $(this).val();

            if(type_charity == 1) { // Fitrah
                $("#zakat_fitrah").show();
                $("#zakat_fidyah").hide();
                $("#infaq").hide();
                $("#sodaqoh").hide();
                $("#zakat_mal").hide();
                $("#waqaf").hide();
            } 
            else if(type_charity == 2) { // Fidyah
                $("#zakat_fitrah").hide();
                $("#zakat_fidyah").show();
                $("#infaq").hide();
                $("#sodaqoh").hide();
                $("#zakat_mal").hide();
                $("#waqaf").hide();
            }
            else if(type_charity == 3) { // Infaq
                $("#zakat_fitrah").hide();
                $("#zakat_fidyah").hide();
                $("#infaq").show();
                $("#sodaqoh").hide();
                $("#zakat_mal").hide();
                $("#waqaf").hide();
            }
            else if(type_charity == 4) { // Shodaqoh
                $("#zakat_fitrah").hide();
                $("#zakat_fidyah").hide();
                $("#infaq").hide();
                $("#sodaqoh").show();
                $("#zakat_mal").hide();
                $("#waqaf").hide();
            }
            else if(type_charity == 5) { // Maal
                $("#zakat_fitrah").hide();
                $("#zakat_fidyah").hide();
                $("#infaq").hide();
                $("#sodaqoh").hide();
                $("#zakat_mal").show();
                $("#waqaf").hide();
            }
            else if(type_charity == 6) { // Waqaf
                $("#zakat_fitrah").hide();
                $("#zakat_fidyah").hide();
                $("#infaq").hide();
                $("#sodaqoh").hide();
                $("#zakat_mal").hide();
                $("#waqaf").show();
            }
            else {
                alert('');
            }
        });
    }
});

function resetAutomaticTypeForm() {
    // $('#qty').val('').trigger('change');
    // $('#receiver-citizens_association_id-victim').val('').trigger('change');
    // $('#receiver-neighborhood_association_id-victim').val('').trigger('change');
    // $('#receiver-clock').val('').trigger('change');
    // $('#victim_type').hide();
}

function resetManuallyTypeForm() {
    // $('#receiver-receiver_class_id').val('').trigger('change');
    // $('#receiver-resident_id').val('').trigger('change');
    // $('#receiver-citizens_association_id-charity').val('').trigger('change');
    // $('#receiver-officer_id').val('').trigger('change');
    // $('#receiver-neighborhood_association_id-charity').val('').trigger('change');
    // $('#receiver-desc').val('').trigger('change');
    // $('#charity_type').hide();
}
JS;

$this->registerJs($js);

?>