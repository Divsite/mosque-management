<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MarriedStatus */

$this->title = Yii::t('app', 'Create Married Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Married Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="married-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
