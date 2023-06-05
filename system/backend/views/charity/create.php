<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Charity */

$this->title = Yii::t('app', 'Create Charity');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Charities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="charity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
