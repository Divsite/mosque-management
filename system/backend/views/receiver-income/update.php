<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReceiverIncome */

$this->title = Yii::t('app', 'Update Receiver Income: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receiver Incomes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="receiver-income-update">
    <?= $this->render('_form', [
        'model' => $model,
        'detailIncomes' => $detailIncomes
    ]) ?>
</div>
