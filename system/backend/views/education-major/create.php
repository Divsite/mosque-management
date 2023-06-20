<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EducationMajor */

$this->title = Yii::t('app', 'Create Education Major');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Education Majors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-major-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
