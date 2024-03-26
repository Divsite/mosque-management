<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReceiverClassSource */

$this->title = Yii::t('app', 'Create Receiver Class Source');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receiver Class Sources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receiver-class-source-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
