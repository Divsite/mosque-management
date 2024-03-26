<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReceiverIncomeType */

$this->title = Yii::t('app', 'Create Receiver Income Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receiver Income Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receiver-income-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
