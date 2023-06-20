<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OwnerStatus */

$this->title = Yii::t('app', 'Create Owner Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Owner Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owner-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
