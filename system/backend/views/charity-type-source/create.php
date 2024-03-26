<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CharityTypeSource */

$this->title = Yii::t('app', 'Create Charity Type Source');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Charity Type Sources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="charity-type-source-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
