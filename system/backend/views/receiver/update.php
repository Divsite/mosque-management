<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver */

$this->title = Yii::t('app', 'Update Receiver: {name}', [
    'receiver_type_id' => $model->receiver_type_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->receiver_type_id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="receiver-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
