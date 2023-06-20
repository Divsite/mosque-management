<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Resident */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'resident'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="resident-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'update_resident'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'nik',
            'telp',
            'identity_card_image',
            'home_image',
            'birth_place',
            'birth_date',
            'gender_id',
            'education_id',
            'education_major_id',
            'married_status_id',
            'nationality_id',
            'religion_id',
            'residence_status_id',
            'province',
            'city',
            'district',
            'postcode',
            'citizen_id',
            'neighborhood_id',
            'address:ntext',
            'family_head_status',
            'dependent_number',
            'interest',
            'registration_date',
        ],
    ]) ?>

</div>
