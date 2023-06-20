<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver */

$this->title = Yii::t('app', 'create_receiver');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'receiver'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
            <div class="receiver-create">

                <?= $this->render('_form', [
                    'model' => $model,
                    'qty' => $qty,
                ]) ?>

            </div>
        </div>
    </div>
</div>
