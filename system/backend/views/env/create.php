<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Env */

$this->title = Yii::t('app', 'Create Env');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Envs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="env-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
