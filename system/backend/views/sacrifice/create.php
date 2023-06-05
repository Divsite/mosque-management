<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sacrifice */

$this->title = Yii::t('app', 'Create Sacrifice');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sacrifices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sacrifice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
