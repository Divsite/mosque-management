<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\ReceiverType;
use backend\models\ReceiverClass;
use backend\models\CitizensAssociation;
use backend\models\NeighborhoodAssociation;
use backend\models\Resident;
use kartik\time\TimePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="receiver-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'receiver_type_id', ['inputOptions'=>['id'=>'receiver_type_id']])->widget(Select2::classname(),[
            'data' => ArrayHelper::map(ReceiverType::find()->all(), 'id', 'name'),
            'options' => [
                'placeholder' => Yii::t('app', 'select_type'),
                'value' => $model->receiver_type_id,
            ],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]);
    ?>

    <div id="charity_type" style="display: none">

        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'receiver_class_id')->widget(Select2::classname(),[
                        'data' => ArrayHelper::map(ReceiverClass::find()->all(), 'id', 'name'),
                        'options' => [
                            'placeholder' => Yii::t('app', 'select_class'),
                            'value' => $model->receiver_class_id,
                        ],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);
                ?>

                <?= $form->field($model, 'resident_id')->widget(Select2::classname(),[
                        'data' => ArrayHelper::map(Resident::find()->with('user')->all(), 'id', 'user.name'),
                        'options' => [
                            'placeholder' => Yii::t('app', 'select_resident'),
                            'value' => $model->resident_id,
                        ],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);
                ?>
                
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>
            </div>
        </div>


    </div>

    <div id="victim_type" style="display: none">

        <?= Html::label(Yii::t('app', 'qty'),['class' => 'control-label']) ?>
        <input type="text" class="form-control" name="qty" id="qty" placeholder="<?= Yii::t('app', 'qty') ?>" value="<?= Yii::$app->request->get('qty')?>">

        <?= $form->field($model, 'citizens_association_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(CitizensAssociation::find()->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => Yii::t('app', 'select_citizens_asociation'),
                    'onChange' => '$.post("'.Url::base().'/reff/citizens?type=C&id='.'" + $(this).val(), function(data) {
                            what = JSON.parse(data);
                            console.log(what);
                            $("#receiver-neighborhood_association_id").html(what.neighborhood);
                        }
                    );',
                ],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]);
        ?>

        <?= $form->field($model, 'neighborhood_association_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(NeighborhoodAssociation::find()->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => Yii::t('app', 'select_neighborhood_association'),
                ],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]);
        ?>

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
    } else if(data == 2) { // sacrifice
        $("#charity_type").hide();
        $("#victim_type").show();
    }
});

JS;

$this->registerJs($js);

?>
