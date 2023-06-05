<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CitizensAssociation */

$this->title = Yii::t('app', 'Create Citizens Association');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Citizens Associations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citizens-association-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
