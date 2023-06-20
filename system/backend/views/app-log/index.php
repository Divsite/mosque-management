<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AppLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'app_log');
$this->params['page_title'] = Yii::t('app', 'index');
$this->params['page_desc'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card table-card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
            <i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="card-text">
            <div class="app-log-index">

                <p>

                    <div class="row">

                        <div class="col-lg-3">

                            <div class="form-group">
                                <?= Html::label(Yii::t('app', 'date_time_log'), 'timestamp', ['class' => 'control-label']) ?>
                                <?= DateTimePicker::widget(['id' => 'timestamp',
                                    'name' => 'timestamp',
                                    'value' => date('Y-m-d 23:59:59'),
                                    'options' => [
                                        'placeholder'  => Yii::t('app', 'date_time_log'),
                                        'autocomplete' => 'off',
                                        'onchange' => ''
                                    ],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd hh:ii:ss'
                                    ]
                                ]) ?>
                            </div>

                        </div>

                        <div class="col-lg-4">

                            <div class="form-group">
                                <?= Html::label('&nbsp;', '', ['class' => 'control-label']) ?>
                                <div class="button-group">
                                    <?= Html::a('<i class="feather icon-trash"></i>' . Yii::t('app', 'clear_all'), ['index', 'action' => 'clear'], [
                                        'class' => 'btn btn-danger clear',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'are_you_sure_want_to_clear_all'),
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </div>

                            </div>

                        </div>

                    </div>

                </p>

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <div class="table-responsive table-nowrap">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pager' => [
                            'firstPageLabel' => 'First',
                            'lastPageLabel'  => 'Last'
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'label' => Yii::t('app', 'username'),
                                'attribute' => 'id_user',
                                'value' => function ($data) {
                                    $user = \backend\models\User::findOne(['id' => $data['id_user']]);
                                    return $user['username'];
                                },
                            ],
                            'module',
                            'activity',
                            'timestamp',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view}',
                                'buttons' => [
                                'view' => function($url, $model) {
                                    return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                        ['view', 'id' => $model['id']], 
                                        ['title' => Yii::t('app', 'view')]);
                                    }
                                ]
                            ],
                        ],
                    ]); ?>

                </div>

            </div>

        </div>

    </div>

    <!-- /.card-body -->
    <div class="card-footer">
        <div class="text-center"><i><?= Html::encode($this->title) ?></i></div>
    </div>
    <!-- /.card-footer-->
</div>

<?php

$url_clear = Url::to(['app-log/index']);

$js = <<< JS

var url_clear = '$url_clear' + '?action=clear' ;

$('.clear').on('click', function(e){
    e.preventDefault();
    $(this).attr('href', function() {
        return url_clear + '&timestamp=' + $('#timestamp').val();
    });
});

$('#timestamp').on('change', function(e) {
    $('.clear').attr('href', function() {
        return url_clear + '&timestamp=' + $('#timestamp').val();
    });

});

JS;

$css = <<< CSS

CSS;

$this->registerJs($js);
$this->registerCss($css);

?>
