<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AboutUsCategory */

$this->title = Yii::t('app', 'Create About Us Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'About Us Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-us-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
