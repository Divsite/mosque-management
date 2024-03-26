<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Receiver */

$this->title = Yii::t('app', 'create_expense');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'expense'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="receiver-create-expense">

    <?= $this->render('_form', [
        'model' => $model,
        'detailExpenses' => $detailExpenses
    ]) ?>

</div>  
