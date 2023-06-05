<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReceiverType */

$this->title = Yii::t('app', 'Create Receiver Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receiver Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receiver-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
