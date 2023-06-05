<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\NeighborhoodAssociation */

$this->title = Yii::t('app', 'Update Neighborhood Association: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Neighborhood Associations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="neighborhood-association-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
