<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BranchCategory */

$this->title = Yii::t('app', 'Create Branch Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Branch Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
