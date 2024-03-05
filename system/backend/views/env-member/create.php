<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EnvMember */

$this->title = Yii::t('app', 'Create Env Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Env Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="env-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
