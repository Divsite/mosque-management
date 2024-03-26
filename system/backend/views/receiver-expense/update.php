<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver */

$this->title = Yii::t('app', 'update_expense');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'expense'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="receiver-update-expense">

    <?= $this->render('_form', [
        'model' => $model,
        'detailExpenses' => $detailExpenses
    ]) ?>

</div>  
