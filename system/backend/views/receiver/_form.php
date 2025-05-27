<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\ReceiverType;
use backend\models\ReceiverClass;
use kartik\time\TimePicker;
use yii\helpers\Url;
use backend\models\Officer;
use backend\models\Village;

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="receiver-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'receiver_type_id', ['inputOptions'=>['id'=>'receiver_type_id']])->widget(Select2::classname(),[
            'data' => ReceiverType::getListReceiverType(),
            'options' => [
                'placeholder' => Yii::t('app', 'select_type'),
                'value' => $model->receiver_type_id,
            ],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]);
    ?>

    <div id="charity_type" <?= $model->receiver_type_id == 2 ? '' : 'style="display: none"' ?>>

        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'receiver_class_id')->widget(Select2::classname(),[
                        'data' => ReceiverClass::getListReceiverClass(),
                        'options' => [
                            'placeholder' => Yii::t('app', 'select_class'),
                            'value' => $model->receiver_class_id,
                            'onChange' => '$.post("'.Url::base().'/receiver/select-receiver-class?id='.'" + $(this).val(), function(data) {
                                what = JSON.parse(data);
                                console.log(data);
                                $("#get_money").text(what.get_money);
                                $("#get_rice").text(what.get_rice);
                            }
                        );',
                        ],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);
                ?>

                <p class="terms"><?= Yii::t('app', 'terms') ?> : </p>
                <div class="terms_content">
                    <span class="label"><?= Yii::t('app', 'get_money') ?> : </span> <span id="get_money"></span>
                </div>
                <div class="terms_content">
                    <span class="label"><?= Yii::t('app', 'get_rice') ?> : </span> <span id="get_rice"></span>
                </div>

                <?= $form->field($model, 'village_id[charity]')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Village::find()->all(), 'id', 'name'),
                        'options' => [
                            'placeholder' => Yii::t('app', 'select_village'),
                            'onChange' => '$.post("'.Url::base().'/reff/citizens?id='.'" + $(this).val(), function(data) {
                                    what = JSON.parse(data);
                                    $("#receiver-citizens_association_id-charity").html(what.citizens);
                                    $("#receiver-neighborhood_association_id-charity").html(what.neighborhood);
                                    $("#receiver-resident_id").html(what.resident);
                                }
                            );',
                        ],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);
                ?>

                <?= $form->field($model, 'citizens_association_id[charity]')->widget(Select2::classname(), [
                        'data' => null,
                        'options' => [
                            'placeholder' => Yii::t('app', 'select_citizens_asociation'),
                            'onChange' => '$.post("'.Url::base().'/reff/neighborhood?id='.'" + $(this).val(), function(data) {
                                    what = JSON.parse(data);
                                    $("#receiver-neighborhood_association_id-charity").html(what.neighborhood);
                                    $("#receiver-resident_id").html(what.resident);
                                }
                            );',
                        ],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);
                ?>

                <?= $form->field($model, 'neighborhood_association_id[charity]')->widget(Select2::classname(), [
                        'data' => null,
                        'options' => [
                            'placeholder' => Yii::t('app', 'select_neighborhood_association'),
                            'onChange' => '$.post("'.Url::base().'/reff/resident?neighborhood='.'" + $(this).val()
                                + "&citizen=" + $("#receiver-citizens_association_id-charity").val()
                                + "&village=" + $("#receiver-village_id-charity").val(), function(data) {
                                what = JSON.parse(data);
                                console.log(what);
                                $("#receiver-resident_id").html(what.resident);
                            });',
                        ],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);
                ?>
                
            </div>
            <div class="col-lg-6">

                <?= Html::label(Yii::t('app', 'resident_id'), 'resident_id', ['class' => 'control-label']) ?>
                <?= Select2::widget([
                    'id' => 'receiver-resident_id',
                    'name' => 'receiver-resident_id',
                    'data' => null,
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_resident'),
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]) ?>

                <?= Html::label(Yii::t('app', 'officer_id'), 'officer_id', ['class' => 'control-label']) ?>
                <?= Select2::widget([
                    'id' => 'receiver-officer_id',
                    'name' => 'receiver-officer_id',
                    'data' => ArrayHelper::map(Officer::find()
                                ->joinWith('user')
                                ->where(['user.level' => Yii::$app->user->identity->level])
                                ->all(), 
                                'id', 'user.name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_officer'),
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]) ?>
                

                <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>
            </div>
        </div>


    </div>

    <div id="victim_type" <?= $model->receiver_type_id == 1 ? '' : 'style="display: none"' ?>>

        <?= Html::label(Yii::t('app', 'qty'),['class' => 'control-label']) ?>
        <input type="text" class="form-control" name="qty" id="qty" placeholder="<?= Yii::t('app', 'qty') ?>" value="<?= Yii::$app->request->get('qty')?>">

        <?= $form->field($model, 'is_committee')->checkbox([
            'label' => Yii::t('app', 'receiver_is_committee'),
            'id' => 'is-committee-flag',
        ]); ?>

        <div id="location-fields">
            <?= $form->field($model, 'village_id[victim]')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Village::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_village'),
                        'onChange' => '$.post("'.Url::base().'/reff/citizens?id='.'" + $(this).val(), function(data) {
                                what = JSON.parse(data);
                                $("#receiver-citizens_association_id-victim").html(what.citizens);
                                $("#receiver-neighborhood_association_id-victim").html(what.neighborhood);
                                $("#receiver-resident_id").html(what.resident);
                            }
                        );',
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'citizens_association_id[victim]')->widget(Select2::classname(), [
                    'data' => null,
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_citizens_asociation'),
                        'onChange' => '$.post("'.Url::base().'/reff/neighborhood?id='.'" + $(this).val(), function(data) {
                                what = JSON.parse(data);
                                $("#receiver-neighborhood_association_id-victim").html(what.neighborhood);
                                $("#receiver-resident_id").html(what.resident);
                            }
                        );',
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'neighborhood_association_id[victim]')->widget(Select2::classname(), [
                    'data' => null,
                    'options' => [
                        'placeholder' => Yii::t('app', 'select_neighborhood_association'),
                        'onChange' => '$.post("'.Url::base().'/reff/resident?neighborhood='.'" + $(this).val()
                            + "&citizen=" + $("#receiver-citizens_association_id-victim").val()
                            + "&village=" + $("#receiver-village_id-victim").val(), function(data) {
                            what = JSON.parse(data);
                            console.log(what);
                            $("#receiver-resident_id").html(what.resident);
                        });',
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>
        </div>

        <?= $form->field($model, 'clock')->widget(TimePicker::classname(), [
            'options' => ['placeholder' => Yii::t('app', 'select_time')],
            'pluginOptions' => [
                'showMeridian' => false,
                // additional plugin options
            ]]);
        ?>
    
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<< JS
// select receiver type conditional
$('#receiver_type_id').on('change', function (e) {
    
    let data = $(this).val();
    $("#charity_type").hide();
    $("#victim_type").hide();

    if(data == 1) { // charity
        $("#charity_type").show();
        $("#victim_type").hide();
        resetVictimTypeForm();

        resetValidation("#receiver-village_id-charity");
        resetValidation("#receiver-village_id-victim");
    } else if(data == 2) { // sacrifice
        $("#charity_type").hide();
        $("#victim_type").show();
        resetCharityTypeForm();

        resetValidation("#receiver-village_id-charity");
        resetValidation("#receiver-village_id-victim");
    }
});

function resetVictimTypeForm() {
    $('#qty').val('').trigger('change');
    $('#receiver-citizens_association_id-victim').val('').trigger('change');
    $('#receiver-neighborhood_association_id-victim').val('').trigger('change');
    $('#receiver-clock').val('').trigger('change');
    $('#victim_type').hide();
}

function resetCharityTypeForm() {
    $('#receiver-receiver_class_id').val('').trigger('change');
    $('#receiver-resident_id').val('').trigger('change');
    $('#receiver-citizens_association_id-charity').val('').trigger('change');
    $('#receiver-officer_id').val('').trigger('change');
    $('#receiver-neighborhood_association_id-charity').val('').trigger('change');
    $('#receiver-desc').val('').trigger('change');
    $('#charity_type').hide();
}

function resetValidation(fieldSelector) {
    $(fieldSelector).prop('required', false);
}

function toggleLocationFields() {
    if ($('#is-committee-flag').is(':checked')) {
        $('#location-fields').hide();
    } else {
        $('#location-fields').show();
    }
}

$('#is-committee-flag').change(function() {
    toggleLocationFields();
});

toggleLocationFields(); // initial check

JS;

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

$this->registerJs($js);
$this->registerCss($css);

?>
