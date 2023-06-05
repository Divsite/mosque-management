<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CharityType */

$this->title = Yii::t('app', 'Create Charity Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Charity Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="charity-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
