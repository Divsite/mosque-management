<?php

use backend\models\Receiver;
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'statistics_dashboard');
$this->params['page_title'] = Yii::t('app', 'dashboard');
$this->params['page_desc'] = Yii::t('app', 'all_information_statistics');
$this->params['title_card'] = Yii::t('app', 'all_information_statistics');

// var_dump(Yii::$app->user->identity->level);
// die;

?>
