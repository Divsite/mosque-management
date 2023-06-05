<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\NeighborhoodAssociation */

$this->title = Yii::t('app', 'Create Neighborhood Association');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Neighborhood Associations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="neighborhood-association-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
