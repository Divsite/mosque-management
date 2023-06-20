<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\WorkStatus */

$this->title = Yii::t('app', 'create_work_status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'work_status'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
