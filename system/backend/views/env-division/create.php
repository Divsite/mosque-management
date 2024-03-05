<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EnvDivision */

$this->title = Yii::t('app', 'Create Env Division');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Env Divisions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="env-division-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
